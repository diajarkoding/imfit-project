<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Mendaftarkan pengguna baru ke dalam sistem.
     *
     * @param RegisterRequest $request Data permintaan yang divalidasi untuk pendaftaran
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan data pengguna yang baru dibuat
     */
    public function register(RegisterRequest $request)
    {
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture_url')) {
            $profilePicturePath = $request->file('profile_picture_url')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'profile_picture_url' => $profilePicturePath,
        ]);

        return $this->success(true, 'Registrasi berhasil. Silakan login.', 201);
    }

    /**
     * Melakukan proses login pengguna ke dalam sistem.
     *
     * @param Request $request Data permintaan yang berisi informasi login dan password
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan token autentikasi atau pesan error
     */
    public function login(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $user = User::where('email', $login)
            ->orWhere('username', $login)
            ->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return $this->error('Gagal Login', 'Nama Pengguna tidak ditemukan/Email belum di konfirmasi', 401);
        }

        // Hapus token lama
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'token' => $token,
        ], 'Login berhasil.');
    }

    /**
     * Melakukan proses logout pengguna dari sistem.
     *
     * @param Request $request Data permintaan autentikasi pengguna
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan pesan berhasil logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(true, 'Berhasil logout.');
    }

    /**
     * Mengambil data profil pengguna yang sedang login.
     *
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan data profil pengguna
     */
    public function getProfile()
    {
        $user = Auth::user();

        $profileData = [
            'fullname' => $user->fullname,
            'username' => $user->username,
            'email' => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'profile_picture_url' => $user->profile_picture_url,
        ];

        return $this->success($profileData, 'Data profil berhasil diambil.');
    }
}

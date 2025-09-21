<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(true, 'Berhasil logout.');
    }

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

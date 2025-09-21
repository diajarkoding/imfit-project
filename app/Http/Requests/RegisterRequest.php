<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string', 'min:3', 'max:255'],
            'username' => ['required', 'string', 'min:8', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[@$!%*#?&_+]/',
            ],
            'date_of_birth' => ['nullable', 'date'],
            'profile_picture_url' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            // Pesan validasi untuk field wajib
            'fullname.required' => 'Nama lengkap tidak boleh kosong.',
            'username.required' => 'Nama pengguna tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'password.required' => 'Kata sandi tidak boleh kosong.',

            // Pesan validasi lain
            'fullname.min' => 'Nama lengkap harus memiliki minimal 3 karakter.',
            'username.min' => 'Nama pengguna harus memiliki minimal 8 karakter.',
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung kombinasi huruf besar, huruf kecil, dan karakter spesial.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'email.email' => 'Format email tidak valid.',
            'profile_picture_url.image' => 'File yang diunggah harus berupa gambar.',
            'profile_picture_url.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $httpStatusCode = 422;

        // Prioritas 1: Periksa error duplikasi username atau email
        if ($errors->has('username') && $errors->first('username') === 'validation.unique') {
            $message = 'Nama Pengguna sudah digunakan.';
            $httpStatusCode = 409;
        } elseif ($errors->has('email') && $errors->first('email') === 'validation.unique') {
            $message = 'Email sudah digunakan.';
            $httpStatusCode = 409;
        } else {
            // Prioritas 2: Ambil error pertama dari semua validasi yang gagal
            $message = $errors->first();
        }

        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'error' => 'Gagal Registrasi',
                'message' => $message,
            ], $httpStatusCode)
        );
    }
}

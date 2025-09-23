<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     * Untuk login, semua pengguna diizinkan.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan login.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string|min:8',
        ];
    }

    /**
     * Menangani kegagalan validasi dengan mengembalikan respons JSON.
     *
     * @param Validator $validator Validator yang berisi error validasi
     * @return void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $errorTitle = 'Gagal Login';
        $message = 'Validasi gagal';

        // Memeriksa apakah ada error pada field password
        if ($errors->has('password')) {
            $message = 'Format kata sandi tidak valid.';
        }

        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'error' => $errorTitle,
                'message' => $message,
            ], 422)
        );
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string|min:8',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $errors = $validator->errors();
        $errorTitle = 'Gagal Login';
        $message = 'Validasi gagal';

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

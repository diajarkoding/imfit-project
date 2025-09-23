<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserWeightRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     * Semua pengguna terautentikasi diizinkan.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan berat badan.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'weight' => 'required|numeric',
            'date' => 'required|date|before_or_equal:today',
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
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'error' => 'Gagal Menambah Berat Badan',
                'message' => $validator->errors(),
            ], 422)
        );
    }
}

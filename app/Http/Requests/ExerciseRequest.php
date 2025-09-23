<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExerciseRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     * Hanya pengguna dengan hak admin yang diizinkan.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
     * Aturan berbeda diterapkan tergantung pada metode HTTP (POST, PUT, PATCH).
     *
     * @return array
     */
    public function rules(): array
    {
        // Aturan default untuk permintaan POST (pembuatan latihan baru)
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'target_muscle' => 'required|string|max:255',
        ];

        // Aturan yang dikurangi untuk permintaan PUT/PATCH (pembaruan latihan)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = 'string|max:255';
            $rules['description'] = 'string';
            $rules['target_muscle'] = 'string|max:255';
        }

        return $rules;
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
                'error' => 'Gagal Menambah Latihan',
                'message' => $validator->errors(),
            ], 422)
        );
    }
}

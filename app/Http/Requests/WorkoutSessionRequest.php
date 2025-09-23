<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WorkoutSessionRequest extends FormRequest
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
     * Mendapatkan aturan validasi yang berlaku untuk permintaan sesi latihan.
     * Memvalidasi struktur data latihan dan set yang kompleks.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'session_name' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'exercises' => 'required|array',
            'exercises.*.id' => 'required|integer|exists:exercises,id',
            'exercises.*.order' => 'required|integer',
            'exercises.*.sets' => 'required|array',
            'exercises.*.sets.*.weight' => 'required|numeric',
            'exercises.*.sets.*.reps' => 'required|integer',
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
                'error' => 'Gagal Menambah Sesi Latihan',
                'message' => $validator->errors(),
            ], 422)
        );
    }
}

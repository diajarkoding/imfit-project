<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WorkoutSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}

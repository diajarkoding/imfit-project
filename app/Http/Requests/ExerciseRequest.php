<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'target_muscle' => 'required|string|max:255',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = 'string|max:255';
            $rules['description'] = 'string';
            $rules['target_muscle'] = 'string|max:255';
        }

        return $rules;
    }

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

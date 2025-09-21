<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success($data = null, string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($errors = null, string $message = 'Error', int $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'error' => $errors,
            'message' => $message,
        ], $code);
    }
}

<?php

namespace App\Traits;

/**
 * Trait untuk menangani respons API yang konsisten.
 *
 * Trait ini menyediakan metode untuk menghasilkan respons JSON yang konsisten
 * untuk keberhasilan dan kesalahan dalam API.
 */
trait ApiResponse
{
    /**
     * Mengembalikan respons JSON sukses.
     *
     * @param mixed $data Data yang akan dikembalikan dalam respons
     * @param string $message Pesan sukses
     * @param int $code Kode status HTTP
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null, string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Mengembalikan respons JSON error.
     *
     * @param mixed $errors Detail kesalahan
     * @param string $message Pesan error
     * @param int $code Kode status HTTP
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($errors = null, string $message = 'Error', int $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'error' => $errors,
            'message' => $message,
        ], $code);
    }
}

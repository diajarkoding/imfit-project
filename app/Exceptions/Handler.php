<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            $status = 500;
            $message = 'Terjadi kesalahan pada server.';
            $errors = null;

            switch (true) {
                case $e instanceof AuthenticationException:
                    $status = 401;
                    $message = 'Tidak terautentikasi.';
                    break;

                case $e instanceof ValidationException:
                    $status = 422;
                    $message = 'Validasi gagal.';
                    $errors = $e->errors();
                    break;

                case $e instanceof HttpResponseException:
                    return $e->getResponse();

                case $e instanceof HttpExceptionInterface:
                    $status = $e->getStatusCode();
                    $message = $e->getMessage() ?: 'Terjadi kesalahan HTTP.';
                    break;

                default:
                    if (config('app.debug')) {
                        $message = $e->getMessage();
                    }
                    break;
            }

            return response()->json([
                'status'  => 'error',
                'message' => $message,
                'errors'  => $errors,
            ], $status);
        }

        return parent::render($request, $e);
    }

    /**
     * Override response default untuk kasus Unauthenticated
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak terautentikasi.',
                'errors'  => null,
            ], 401);
        }

        return redirect()->guest(route('login'));
    }
}

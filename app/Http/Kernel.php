<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Tumpukan middleware HTTP global aplikasi.
     *
     * Middleware ini dijalankan selama setiap permintaan ke aplikasi Anda.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // Middleware global (selalu dijalankan)
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Grup middleware rute aplikasi.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Pembatasan kecepatan bawaan Laravel (60 permintaan per menit untuk grup "api")
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware rute aplikasi.
     *
     * Middleware ini dapat ditugaskan ke grup atau digunakan secara individual.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed'     => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'   => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Middleware kustom Anda
        'is_admin'   => \App\Http\Middleware\IsAdminMiddleware::class,
    ];
}

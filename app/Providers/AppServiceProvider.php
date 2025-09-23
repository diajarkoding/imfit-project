<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Mendaftarkan layanan aplikasi apa pun.
     *
     * Metode ini digunakan untuk mendaftarkan layanan ke container IoC (Inversion of Control).
     * Ini dipanggil sebelum metode boot().
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap layanan aplikasi apa pun.
     *
     * Metode ini digunakan untuk melakukan bootstrap terhadap layanan yang telah didaftarkan.
     * Ini dipanggil setelah semua layanan lainnya telah didaftarkan.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware
{
    use ApiResponse;

    /**
     * Menangani permintaan yang masuk untuk memeriksa apakah pengguna adalah admin.
     * Middleware ini akan membatasi akses ke rute tertentu hanya untuk pengguna dengan hak admin.
     *
     * @param  \Illuminate\Http\Request  $request  Objek permintaan HTTP
     * @param  \Closure  $next  Closure untuk melanjutkan ke middleware berikutnya
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa apakah pengguna telah terautentikasi dan memiliki hak admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Mengembalikan respons error jika pengguna bukan admin
        return response()->json([
            'status' => 'error',
            'message' => 'Akses ditolak. Anda tidak memiliki izin admin.',
            'errors' => 'error',
        ], 403);
    }
}

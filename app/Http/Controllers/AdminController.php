<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;

class AdminController extends Controller
{
    use ApiResponse;

    /**
     * Mengambil daftar semua pengguna dalam sistem.
     *
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan daftar pengguna
     */
    public function getUsers()
    {
        $users = User::all();

        return $this->success($users);
    }
}

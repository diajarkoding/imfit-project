<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;

class AdminController extends Controller
{
    use ApiResponse;

    public function getUsers()
    {
        $users = User::all();

        return $this->success($users);
    }
}

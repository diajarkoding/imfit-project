<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

// Public routes (tidak butuh token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (butuh token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // API Latihan (untuk semua pengguna terotentikasi)
    Route::get('/exercises', [ExerciseController::class, 'index']);

    // API Sesi Latihan (untuk semua pengguna)
    Route::post('/workouts', [WorkoutController::class, 'store']);

    // API Pelacakan Kemajuan (untuk semua pengguna)
    Route::post('/weights', [ProgressController::class, 'storeWeight']);
    Route::get('/weights/history', [ProgressController::class, 'getWeightHistory']);

    // API khusus Admin (membutuhkan middleware 'is_admin')
    Route::middleware('is_admin')->group(function () {
        Route::post('/exercises', [ExerciseController::class, 'store']);
        Route::put('/exercises/{exercise}', [ExerciseController::class, 'update']);
        Route::delete('/exercises/{exercise}', [ExerciseController::class, 'destroy']);
        Route::get('/admin/users', [AdminController::class, 'getUsers']);
    });
});

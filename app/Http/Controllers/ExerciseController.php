<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExerciseRequest;
use App\Models\Exercise;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $exercises = Exercise::all();

        return $this->success($exercises);
    }

    public function store(ExerciseRequest $request)
    {
        $exercise = Exercise::create(array_merge($request->validated(), [
            'created_by_admin_id' => Auth::id(),
        ]));

        return $this->success($exercise, 'Latihan berhasil ditambahkan.', 201);
    }

    public function update(ExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update($request->validated());

        return $this->success($exercise, 'Latihan berhasil diperbarui.');
    }

    public function destroy(Exercise $exercise)
    {
        if (Auth::user()->id !== $exercise->created_by_admin_id) {
            return $this->error('Akses ditolak. Anda hanya bisa menghapus latihan yang Anda buat.', null, 403);
        }
        $exercise->delete();

        return $this->success(null, 'Latihan berhasil dihapus.');
    }
}

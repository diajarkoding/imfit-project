<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExerciseRequest;
use App\Models\Exercise;
use App\Traits\ApiResponse;
use Illuminate\Http\Request; // Tambahkan ini
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    use ApiResponse;

    /**
     * Mengambil daftar latihan dengan paginasi dan fitur pencarian.
     * Field yang ditampilkan terbatas untuk efisiensi.
     */
    public function index(Request $request)
    {
        $query = Exercise::select('id', 'name', 'target_muscle');

        // Fitur pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('target_muscle', 'like', "%{$searchTerm}%");
        }

        // Paginasi, 10 item per halaman secara default
        $exercises = $query->paginate(10);

        return $this->success($exercises, 'Daftar latihan berhasil diambil.');
    }

    /**
     * Mengambil detail lengkap dari satu latihan berdasarkan ID.
     */
    public function show(Exercise $exercise)
    {
        return $this->success($exercise, 'Detail latihan berhasil diambil.');
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
            return $this->error('Menghapus latihan', 'Akses ditolak. Anda hanya bisa menghapus latihan yang Anda buat.', 403);
        }
        $exercise->delete();

        return $this->success(null, 'Latihan berhasil dihapus.');
    }
}

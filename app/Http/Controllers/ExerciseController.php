<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExerciseRequest;
use App\Models\Exercise;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    use ApiResponse;

    /**
     * Mengambil daftar latihan dengan paginasi dan fitur pencarian.
     * Field yang ditampilkan terbatas untuk efisiensi.
     *
     * @param Request $request Data permintaan yang berisi parameter pencarian (opsional)
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan daftar latihan
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
     *
     * @param Exercise $exercise Model latihan yang akan ditampilkan
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan detail latihan
     */
    public function show(Exercise $exercise)
    {
        return $this->success($exercise, 'Detail latihan berhasil diambil.');
    }

    /**
     * Menyimpan latihan baru ke dalam database.
     *
     * @param ExerciseRequest $request Data permintaan yang divalidasi untuk latihan baru
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan data latihan yang baru dibuat
     */
    public function store(ExerciseRequest $request)
    {
        $exercise = Exercise::create(array_merge($request->validated(), [
            'created_by_admin_id' => Auth::id(),
        ]));

        return $this->success($exercise, 'Latihan berhasil ditambahkan.', 201);
    }

    /**
     * Memperbarui data latihan yang sudah ada.
     *
     * @param ExerciseRequest $request Data permintaan yang divalidasi untuk pembaruan latihan
     * @param Exercise $exercise Model latihan yang akan diperbarui
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan data latihan yang telah diperbarui
     */
    public function update(ExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update($request->validated());

        return $this->success($exercise, 'Latihan berhasil diperbarui.');
    }

    /**
     * Menghapus latihan dari database.
     *
     * @param Exercise $exercise Model latihan yang akan dihapus
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan pesan hasil penghapusan
     */
    public function destroy(Exercise $exercise)
    {
        // Memeriksa apakah pengguna adalah pembuat latihan
        if (Auth::user()->id !== $exercise->created_by_admin_id) {
            return $this->error('Menghapus latihan', 'Akses ditolak. Anda hanya bisa menghapus latihan yang Anda buat.', 403);
        }
        
        $exercise->delete();

        return $this->success(null, 'Latihan berhasil dihapus.');
    }
}

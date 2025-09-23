<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserWeightRequest;
use App\Models\UserWeight;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    use ApiResponse;

    /**
     * Menyimpan data berat badan pengguna.
     *
     * @param UserWeightRequest $request Data permintaan yang divalidasi untuk berat badan
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan data berat badan yang disimpan
     */
    public function storeWeight(UserWeightRequest $request)
    {
        $userWeight = UserWeight::create([
            'user_id' => Auth::id(),
            'weight_kg' => $request->weight,
            'date' => $request->date,
        ]);

        return $this->success($userWeight, 'Berat badan berhasil disimpan.', 201);
    }

    /**
     * Mengambil riwayat berat badan pengguna yang diurutkan berdasarkan tanggal.
     *
     * @return \Illuminate\Http\JsonResponse Respons JSON dengan riwayat berat badan
     */
    public function getWeightHistory()
    {
        $history = Auth::user()->userWeights()->orderBy('date')->get();

        return $this->success($history);
    }
}

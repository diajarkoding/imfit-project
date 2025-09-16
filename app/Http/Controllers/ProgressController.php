<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserWeightRequest;
use App\Models\UserWeight;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    use ApiResponse;

    public function storeWeight(UserWeightRequest $request)
    {
        $userWeight = UserWeight::create([
            'user_id' => Auth::id(),
            'weight_kg' => $request->weight,
            'date' => $request->date,
        ]);

        return $this->success($userWeight, 'Berat badan berhasil disimpan.', 201);
    }

    public function getWeightHistory()
    {
        $history = Auth::user()->userWeights()->orderBy('date')->get();

        return $this->success($history);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkoutSessionRequest;
use App\Models\WorkoutSession;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    use ApiResponse;

    public function store(WorkoutSessionRequest $request)
    {
        $totalVolume = 0;
        $totalDuration = now()->parse($request->end_time)->diffInMinutes(now()->parse($request->start_time));

        DB::beginTransaction();
        try {
            $session = WorkoutSession::create([
                'user_id' => Auth::id(),
                'session_name' => $request->session_name,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'total_duration_in_minutes' => $totalDuration,
                'total_volume_kg' => 0,
            ]);

            foreach ($request->exercises as $exerciseData) {
                $sessionExercise = $session->sessionExercises()->create([
                    'exercise_id' => $exerciseData['id'],
                    'order' => $exerciseData['order'],
                ]);

                foreach ($exerciseData['sets'] as $setData) {
                    $sessionExercise->sets()->create([
                        'weight' => $setData['weight'],
                        'reps' => $setData['reps'],
                    ]);
                    $totalVolume += $setData['weight'] * $setData['reps'];
                }
            }

            $session->update(['total_volume_kg' => $totalVolume]);

            DB::commit();

            return $this->success($session->load('sessionExercises.sets', 'sessionExercises.exercise'), 'Sesi latihan berhasil disimpan.', 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error('Gagal menyimpan sesi latihan.', ['exception' => $e->getMessage()], 500);
        }
    }
}

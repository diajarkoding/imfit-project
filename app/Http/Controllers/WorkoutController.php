<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkoutSessionRequest;
use App\Models\WorkoutSession;
use App\Traits\ApiResponse;
use Illuminate\Http\Request; // Import Request
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

            return $this->success(null, 'Sesi latihan berhasil disimpan.', 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error('Sesi Latihan', 'Gagal menyimpan sesi latihan.', 500);
        }
    }

    /**
     * Mengambil daftar riwayat latihan dengan paginasi dan pencarian.
     * Hanya memuat field yang dibutuhkan untuk efisiensi.
     */
    public function getHistory(Request $request)
    {
        $query = Auth::user()
            ->workoutSessions()
            ->select('id', 'session_name', 'total_duration_in_minutes', 'total_volume_kg', 'start_time', 'end_time');

        // Fitur pencarian berdasarkan nama sesi
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('session_name', 'like', "%{$searchTerm}%");
        }

        // Paginasi, 15 item per halaman secara default
        $history = $query->orderBy('start_time', 'desc')->paginate(10);

        return $this->success($history, 'Riwayat latihan berhasil diambil.');
    }

    /**
     * Mengambil detail lengkap satu sesi latihan berdasarkan ID.
     */
    public function show(WorkoutSession $workoutSession)
    {
        $session = $workoutSession->load([
            'sessionExercises' => function ($query) {
                $query->select('id', 'workout_session_id', 'exercise_id', 'order')
                    ->orderBy('order');
            },
            'sessionExercises.exercise' => function ($query) {
                $query->select('id', 'name', 'target_muscle', 'description');
            },
            'sessionExercises.sets' => function ($query) {
                $query->select('id', 'session_exercise_id', 'weight', 'reps');
            },
        ]);

        return $this->success($session, 'Detail sesi latihan berhasil diambil.');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_session_id',  // ✅ perbaikan nama kolom
        'exercise_id',
        'order',
    ];

    public function workoutSession()
    {
        return $this->belongsTo(WorkoutSession::class, 'workout_session_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function sets()
    {
        return $this->hasMany(SessionSet::class, 'session_exercise_id');
    }
}

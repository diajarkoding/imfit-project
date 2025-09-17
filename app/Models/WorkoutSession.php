<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_name',
        'start_time',
        'end_time',
        'total_volume_kg',
        'total_duration_in_minutes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sessionExercises()
    {
        return $this->hasMany(SessionExercise::class, 'workout_session_id');
    }
}

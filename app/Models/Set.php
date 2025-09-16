<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_exercise_id',
        'weight',
        'reps'
    ];

    public function sessionExercise()
    {
        return $this->belongsTo(SessionExercise::class);
    }
}
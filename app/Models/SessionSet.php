<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionSet extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'session_exercise_id',
        'weight',
        'reps',
    ];

    /**
     * Mendapatkan latihan sesi yang terkait dengan set ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sessionExercise()
    {
        return $this->belongsTo(SessionExercise::class, 'session_exercise_id');
    }
}

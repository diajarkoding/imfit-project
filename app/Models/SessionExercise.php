<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionExercise extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'workout_session_id',  // ✅ perbaikan nama kolom
        'exercise_id',
        'order',
    ];

    /**
     * Mendapatkan sesi latihan yang terkait dengan latihan sesi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workoutSession()
    {
        return $this->belongsTo(WorkoutSession::class, 'workout_session_id');
    }

    /**
     * Mendapatkan latihan yang terkait dengan latihan sesi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Mendapatkan semua set yang terkait dengan latihan sesi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sets()
    {
        return $this->hasMany(SessionSet::class, 'session_exercise_id');
    }
}

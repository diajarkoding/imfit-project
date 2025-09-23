<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSession extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'session_name',
        'start_time',
        'end_time',
        'total_volume_kg',
        'total_duration_in_minutes',
    ];

    /**
     * Mendapatkan pengguna yang terkait dengan sesi latihan ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan semua latihan sesi yang terkait dengan sesi latihan ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessionExercises()
    {
        return $this->hasMany(SessionExercise::class, 'workout_session_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $workout_session_id
 * @property int $exercise_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Exercise $exercise
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SessionSet> $sets
 * @property-read int|null $sets_count
 * @property-read \App\Models\WorkoutSession $workoutSession
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise whereExerciseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionExercise whereWorkoutSessionId($value)
 * @mixin \Eloquent
 */
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

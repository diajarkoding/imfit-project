<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $session_name
 * @property string $start_time
 * @property string $end_time
 * @property string $total_volume_kg
 * @property int $total_duration_in_minutes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SessionExercise> $sessionExercises
 * @property-read int|null $session_exercises_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereSessionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereTotalDurationInMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereTotalVolumeKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkoutSession whereUserId($value)
 * @mixin \Eloquent
 */
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

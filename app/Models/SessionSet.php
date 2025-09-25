<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $session_exercise_id
 * @property string $weight
 * @property int $reps
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SessionExercise $sessionExercise
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet whereReps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet whereSessionExerciseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionSet whereWeight($value)
 * @mixin \Eloquent
 */
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

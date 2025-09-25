<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $weight_kg
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWeight whereWeightKg($value)
 * @mixin \Eloquent
 */
class UserWeight extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'weight_kg',
        'date',
    ];

    /**
     * Mendapatkan pengguna yang terkait dengan catatan berat badan ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

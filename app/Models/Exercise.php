<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'target_muscle',
        'created_by_admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by_admin_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $fillable = [
        'user_id',
        'target_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

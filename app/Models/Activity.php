<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'action_id',
        'action_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'name', 'avatar']);
    }
}

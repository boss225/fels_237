<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'spent_time',
        'result',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function tests()
    {
        return $this->belongsTo(Test::class);
    }
}

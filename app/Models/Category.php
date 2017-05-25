<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
    ];

    public function words()
    {
        return $this->hasMany(Word::class);
    }
    public function tests()
    {
        return $this->hasOne(Test::class);
    }
}

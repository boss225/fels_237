<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
    ];

    public function test()
    {
        return $this->hasOne(Test::class);
    }
    
    public function words()
    {
        return $this->hasMany(Word::class);
    }
}

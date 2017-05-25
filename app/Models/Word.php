<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'category_id',
        'word',
        'answer',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
        public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

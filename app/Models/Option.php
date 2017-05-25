<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'word_id',
        'option',
    ];

    public function words()
    {
        return $this->belongsTo(Word::class);
    }
}

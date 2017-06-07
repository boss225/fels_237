<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'category_id',
        'word',
        'description',
        'answer',
    ];

    public function options()
    {
        return $this->hasMany(Option::class, 'word_id')->select(['id', 'option', 'word_id']);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_word', 'word_id', 'user_id')
            ->where('user_id', auth()->user()->id);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

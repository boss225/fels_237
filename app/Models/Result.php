<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'lesson_id',
        'word_id',
        'user_answer',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->select(['id', 'created_at']);
    }

    public function word()
    {
        return $this->belongsTo(Word::class, 'word_id')->select(['id', 'word', 'answer']);
    }
}

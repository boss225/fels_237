<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $attributes = [
        'avatar' => '/uploads/page/avatar.jpg',
        'cover' => '/uploads/page/cover.jpg',
        'note' => 'Hard working, friendly, helping people',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'avatar', 
        'cover', 
        'location', 
        'note'
    ];

    protected $guarded = [
        'role'                  // 0:admin ,1:user
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function relationships()
    {
        return $this->hasMany(Relationship::class);
    }

    public function social()
    {
        return $this->hasOne(Social::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function words()
    {
        return $this->belongsToMany(Word::class);
    }

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = bcrypt($value);
    }
    
}

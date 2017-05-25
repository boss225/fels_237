<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'cover', 'location', 'note', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function relationships()
    {
        return $this->hasMany(Relationship::class);
    }
    public function socials()
    {
        return $this->hasMany(Social::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function words()
    {
        return $this->belongsToMany(Word::class);
    }
}

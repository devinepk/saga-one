<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the journals that this user has created
     */
    public function journals_created()
    {
        return $this->hasMany('App\Journal', 'creator_id');
    }

    /**
     * Get the journals that this user currently has in possession
     */
    public function journals_current()
    {
        return $this->hasMany('App\Journal', 'current_user_id');
    }

    /**
     * Get the journals that this user belongs to
     */
    public function journals()
    {
        return $this->belongsToMany('App\Journal')
            ->as('subscriber')
            ->withPivot('next_user_id', 'deleted_at')
            ->withTimestamps();
    }
}

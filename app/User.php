<?php

namespace App;

use App\Notifications\VerifyEmailNotification;
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
     * Send the email verification notification.
     * This method overrides the MustVerifyEmail trait.
     * See /Illuminate/Auth/MustVerifyEmail.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

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
    public function current_journals()
    {
        return $this->hasMany('App\Journal', 'current_user_id');
    }

    /**
     * Get the journals that this user belongs to
     */
    public function journals()
    {
        return $this->belongsToMany('App\Journal')
            ->as('subscription')
            ->withPivot('next_user_id', 'deleted_at')
            ->withTimestamps();
    }

    /**
     * Get the entries that this user has written
     */
    public function entries()
    {
        return $this->hasMany('App\Entry', 'author_id');
    }

    /**
     * Get the invites that this user has sent
     */
    public function invites_sent()
    {
        return $this->hasMany('App\Invite', 'sender_id');
    }

    /**
     * Get the comments this user has posted.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the invite associated with this user, if applicable.
     */
    public function invites_received()
    {
        return $this->hasMany('App\Invite', 'user_id');
    }

    /**
     * Check whether the user belongs to a given journal
     *
     * @param  \App\Journal  $journal
     * @return boolean
     */
    public function isInJournal(Journal $journal)
    {
        return in_array($journal->id, array_column($this->journals->all(), 'id'));
    }

    /**
     * Get the active journals NOT currently in the user's possession
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOtherJournalsAttribute()
    {
        return $this->journals()->where('current_user_id', '<>', $this->id)->get();
    }
}

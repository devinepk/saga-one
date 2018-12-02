<?php

namespace App;

use App\Comment;
use App\Entry;
use App\Invite;
use App\Journal;
use App\Notifications\QueuedResetPassword;
use App\Notifications\QueuedVerifyEmail;
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
        return $this->hasMany(Journal::class, 'creator_id');
    }

    /**
     * Get the journals that this user currently has in possession
     */
    public function current_journals()
    {
        return $this->hasMany(Journal::class, 'current_user_id');
    }

    /**
     * Get the journals that this user belongs to
     */
    public function journals()
    {
        return $this->belongsToMany(Journal::class)
            ->as('subscription')
            ->withPivot('next_user_id', 'deleted_at')
            ->withTimestamps();
    }

    /**
     * Get the entries that this user has written
     */
    public function entries()
    {
        return $this->hasMany(Entry::class, 'author_id');
    }

    /**
     * Get the invites that this user has sent
     */
    public function invites_sent()
    {
        return $this->hasMany(Invite::class, 'sender_id');
    }

    /**
     * Get the comments this user has posted.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the invite associated with this user, if applicable.
     */
    public function invites_received()
    {
        return $this->hasMany(Invite::class, 'user_id');
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
        return $this->journals()->where('current_user_id', '<>', $this->id)->with(['invites' => function ($query) {
                $query->where('accepted_at', null)->where('declined_at', null);
            }])->get();
    }

    /**
     * Send the password reset notification.
     * Overrides the method in Illuminate\Contracts\Auth\CanResetPassword
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new QueuedResetPassword($token));
    }

    /**
     * Send the email verification notification.
     * Overrides the method in Illuminate\Contracts\Auth\MustVerifyEmail
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new QueuedVerifyEmail);
    }
}

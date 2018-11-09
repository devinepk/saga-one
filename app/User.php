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
     * The attributes that should be append to the model's array form
     * and can be accessed with the accessor methods below.
     *
     * @var array
     */
    protected $appends = ['current_journals', 'other_journals'];

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
    public function invites()
    {
        return $this->hasMany('App\Invite', 'sender_id');
    }

    /**
     * Check whether the user belongs to a given journal
     *
     * @param  \App\Journal  $journal
     * @return boolean
     */
    public function isInJournal(Journal $journal) {
        foreach ($this->journals as $user_journal) {
            if ($journal->id == $user_journal->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the journals currently in the user's possession
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getCurrentJournalsAttribute() {
        $current_journals = [];

        foreach ($this->journals as $journal) {
            if ($journal->current_user->id == $this->id) {
                $current_journals[] = $journal;
            }
        }

        return collect($current_journals);
    }

    /**
     * Get the journals NOT currently in the user's possession
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOtherJournalsAttribute() {
        $other_journals = [];

        foreach ($this->journals as $journal) {
            if ($journal->current_user->id != $this->id) {
                $other_journals[] = $journal;
            }
        }

        return collect($other_journals);
    }
}

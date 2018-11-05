<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be append to the model's array form
     * and can be accessed with the accessor methods below.
     *
     * @var array
     */
    protected $appends = ['queue', 'next_user'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the user that created this journal
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that currently has this journal in possession
     */
    public function current_user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the users that belong to this journal
     */
    public function users()
    {
        return $this->belongsToMany('App\User')
            ->as('subscription')
            ->withPivot('next_user_id', 'deleted_at')
            ->withTimestamps();
    }

    /**
     * Access the computed attribute "queue", which represents
     * the list of users "waiting" for the journal. The current user
     * will not be in this list.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getQueueAttribute()
    {
        $queue = [];

        if ($this->users()->count() > 1) {

            $next_user = $this->users()->find($this->next_user);

            do {
                $queue[] = $next_user;
                $next_user = $this->users()->find($next_user->subscription->next_user_id);
            } while ($next_user->id != $this->current_user->id);
        }

        return collect($queue);
    }

    /**
     * Access the computed attribute "next_user", which represents
     * the next user in line for this journal
     *
     * @return int id of the next user
     */
    public function getNextUserAttribute() {
        return $this->users()->find($this->current_user->id)->subscription->next_user_id;
    }

    /**
     * Get the entries for this journal.
     */
    public function entries()
    {
        return $this->hasMany('App\Entry')->orderBy('updated_at', 'desc');
    }

    /**
     * Check whether a given user subscribes to this journal
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function hasUser(User $user) {
        foreach ($this->users as $journal_user) {
            if ($user->id == $journal_user->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the next entry in the journal, or null if there is none
     *
     * @param \App\Entry
     * @return \App\Entry || null
     */
    public function getEntryAfter(Entry $entry) {
        return $this->entries()
            ->where('created_at', '>', $entry->created_at)
            ->get()
            ->sortBy('created_at')
            ->first();
    }

    /**
     * Get the previous entry in the journal, or null if there is none
     *
     * @param \App\Entry
     * @return \App\Entry || null
     */
    public function getEntryBefore(Entry $entry) {
        return $this->entries()
            ->where('created_at', '<', $entry->created_at)
            ->get()
            ->sortByDesc('created_at')
            ->first();
    }
}

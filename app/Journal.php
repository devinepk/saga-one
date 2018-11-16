<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Journal extends Model
{

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
        return $this->belongsTo('App\User')->withDefault();
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

            // The queue of an archived journal should start with the creator.
            $first_user_id = $this->current_user->id ? $this->current_user->id : $this->creator->id;
            $next_user = $this->users()->find($first_user_id);

            do {
                $queue[] = $next_user;
                $next_user = $this->users()->find($next_user->subscription->next_user_id);
            } while ($next_user->id != $first_user_id);
        }

        return collect($queue);
    }

    /**
     * Access the computed attribute "next_user", which represents
     * the next user in line for this journal
     *
     * @return \App\User
     */
    public function getNextUserAttribute()
    {
        $next_user_id = $this->users()->find($this->current_user->id)->subscription->next_user_id;
        return $this->users()->find($next_user_id);
    }

    /**
     * Attach a given user to this journal and add them to the end of the queue.
     *
     * @return \App\User
     */
    public function appendToQueue(User $user)
    {
        if ($this->queue->count()) {
            // If we have a queue, then find the first and last users in line.
            $last = $this->queue->reverse()->first();
            $first = $this->queue->first();

        } else {
            // Otherwise the creator is the only one in line.
            $last = $this->creator;
            $first = $this->creator;
        }

        // The last user in the queue will come before the new user.
        $this->users()->updateExistingPivot($last->id, ['next_user_id' => $user->id]);

        // Attach the new user.
        // The first user in the queue will come after the new user.
        $this->users()->attach($user, ['next_user_id' => $first->id]);
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
    public function hasUser(User $user)
    {
        return in_array($user->id, array_column($this->users->all(), 'id'));
    }

    /**
     * Get the next entry in the journal, or null if there is none
     *
     * @param \App\Entry $entry
     * @param bool $no_drafts
     * @return \App\Entry || null
     */
    public function getEntryAfter(Entry $entry, $no_drafts = true)
    {
        $params = [
            ['updated_at', '>', $entry->updated_at]
        ];
        if ($no_drafts) {
            $params[] = ['status', 'final'];
        }
        return $this->entries()
            ->where($params)
            ->get()
            ->sortBy('updated_at')
            ->first();
    }

    /**
     * Get the previous entry in the journal, or null if there is none
     *
     * @param \App\Entry $entry
     * @param bool $no_drafts
     * @return \App\Entry || null
     */
    public function getEntryBefore(Entry $entry, $no_drafts = true)
    {
        $params = [
            ['updated_at', '<', $entry->updated_at]
        ];
        if ($no_drafts) {
            $params[] = ['status', 'final'];
        }
        return $this->entries()
            ->where($params)
            ->get()
            ->sortByDesc('updated_at')
            ->first();
    }

    /**
     * Get the invites that have been sent for this journal.
     */
    public function invites()
    {
        return $this->hasMany('App\Invite')->orderBy('created_at', 'desc');
    }

    /**
     * Rotate this journal to the next user
     */
    public function rotate()
    {
        // Update the current user to the next user
        $this->current_user()->associate($this->next_user->id);
        // Update the date of the next rotation
        $this->next_change = (new Carbon($this->next_change))->addSeconds($this->period);
        $this->save();
    }
}

<?php

namespace App;

use App\Comment;
use App\Entry;
use App\Invite;
use App\User;
use App\Notifications\TurnHasEnded;
use App\Notifications\TurnHasStarted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Journal extends Model
{
    use Notifiable;

    /**
     * The default cover image to use if another isn't specified
     *
     * @var array
     */
    public $default_image_path = 'img/cover1.jpg';

    /**
     * The attributes that should be cast to Carbon date instances.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'next_change', 'last_change'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['action_urls', 'next_user', 'pending_invites', 'queue'];

    /**
     * Get the user that created this journal
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that currently has this journal in possession
     */
    public function current_user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the users that belong to this journal
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->as('subscription')
            ->withPivot('next_user_id', 'deleted_at')
            ->withTimestamps();
    }

    /**
     * Access the computed attribute "queue", which represents
     * the list of users "waiting" for the journal. The current user
     * will be at the start of this list.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getQueueAttribute()
    {
        $queue = [];

        // The queue of an archived journal should start with the creator.
        // An archived journal has no current_user.
        if (isset($this->current_user)) {
            $next_user = $this->users()->find($this->current_user_id);
        } else {
            $next_user = $this->users()->find($this->creator_id);
        }

        $first_user_id = $next_user->id;
        do {
            $queue[] = $next_user;
            $next_user = $this->users()->find($next_user->subscription->next_user_id);
        } while (isset($next_user) && $next_user->id != $first_user_id);

        return collect($queue);
    }

    /**
     * Access the computed attribute "next_user", which represents
     * the next user in line for this journal
     *
     * @return \App\User|null
     */
    public function getNextUserAttribute()
    {
        if (empty($this->current_user)) {
            return null;
        }
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
        if ($this->users->count() > 1) {
            // Find the first and last users in line.
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

        // Set the next change date if necessary
        if (blank($this->next_change)) {
            $this->next_change = now()->addSeconds($this->period);
            $this->save();
        }
    }

    /**
     * Get the entries for this journal.
     */
    public function entries()
    {
        return $this->hasMany(Entry::class)->orderBy('updated_at', 'desc');
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
     * @return \App\Entry|null
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
     * @return \App\Entry|null
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
        return $this->hasMany(Invite::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the pending invites for this journal.
     * Pending invites have been neither accepted nor declined.
     */
    public function getPendingInvitesAttribute()
    {
        return $this->invites()->where('accepted_at', null)->where('declined_at', null)->get();
    }

    /**
     * Rotate this journal to the next user
     *
     * @return void
     */
    public function rotate()
    {
        // Update the current user to the next user
        $this->current_user()->associate($this->next_user->id);

        // Update the date of the next rotation
        $this->last_change = $this->next_change;
        $this->next_change = $this->next_change->addSeconds($this->period);
        $this->save();

        // Mark all draft entries as "final"
        $this->entries()->whereStatus('draft')->update(['status' => 'final']);
    }

    /**
     * Notify the current user that the journal is in their possession
     *
     * @return void
     */
    public function sendTurnHasStartedNotification()
    {
        $this->current_user->notify(new TurnHasStarted($this));
    }

    /**
     * Notify the current user that their turn has ended
     *
     * @param \App\User $next_user
     * @return void
     */
    public function sendTurnHasEndedNotification(User $next_user)
    {
        $this->current_user->notify(new TurnHasEnded($this, $next_user));
    }

    /**
     * Get a formatted date of next change for this journal
     *
     * @return \Carbon\Carbon
     */
    public function getFormattedNextChangeAttribute()
    {
        return (new Carbon($this->next_change, config('timezone', 'America/New_York')))
                    ->format('F jS \\a\\t g:ia');
    }

    /**
     * Get the journal cover image.
     *
     * Returns the image_path stored in the database, or the default
     * image_path if no custom image has been uploaded.
     *
     * @param  string $value
     * @return string path to the journal cover image
     */
    public function getImagePathAttribute($value)
    {
        return $value ?: $this->default_image_path;
    }

    /**
     * Does this journal have a custom cover image?
     *
     * @return bool
     */
    public function getHasCustomImageAttribute()
    {
        return ($this->image_path != $this->default_image_path);
    }

    /**
     * Form the action urls for this journal
     *
     * @return bool
     */
    public function getActionUrlsAttribute()
    {
        $urls = ['image' => Storage::url($this->image_path)];

        if (Auth::check()) {
            // If someone is logged in, only return the urls this user is allowed to access
            $urls['write']    = Auth::user()->can('addEntry', $this)     ? route('journal.show', $this)     : '';
            $urls['read']     = Auth::user()->can('view', $this)         ? route('journal.contents', $this) : '';
            $urls['settings'] = Auth::user()->can('viewSettings', $this) ? route('journal.settings', $this) : '';
        } else {
            $urls['write']    = route('journal.show', $this);
            $urls['read']     = route('journal.contents', $this);
            $urls['settings'] = route('journal.settings', $this);
        }

        return $urls;
    }
}

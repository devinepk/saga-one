<?php

namespace App;

use App\Comment;
use App\Invite;
use App\Journal;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Entry extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['action_urls'];

    /**
     * Get the journal that owns this entry.
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    /**
     * Get the user that wrote this entry.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the comments about this entry.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->oldest();
    }

    /**
     * Form the action urls for this entry
     *
     * @return bool
     */
    public function getActionUrlsAttribute()
    {
        $urls = [];

        $previous_entry = $this->journal->getEntryBefore($this);
        $urls['previous'] = $previous_entry ? route('entry.show', $previous_entry) : '';

        $next_entry = $this->journal->getEntryAfter($this);
        $urls['next'] = $next_entry ? route('entry.show', $next_entry) : '';

        if (Auth::check()) {
            // If someone is logged in, only return the urls this user is allowed to access
            $urls['edit'] = Auth::user()->can('update', $this) ? route('entry.edit', $this) : '';
        } else {
            $urls['edit'] = route('entry.edit', $this);
        }

        return $urls;
    }
}

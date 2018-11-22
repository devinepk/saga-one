<?php

namespace App;

use App\Comment;
use App\Invite;
use App\Journal;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Entry extends Model
{

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
        return $this->hasMany(Comment::class);
    }
}

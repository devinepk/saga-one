<?php

namespace App;

use App\Entry;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Get the entry that this comment belongs to.
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * Get the user that this comment belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the message attribute for this comment.
     *
     * @param  string $value
     * @return string
     */
    public function getMessageAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }
}

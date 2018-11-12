<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Get the entry that this comment belongs to.
     */
    public function entry()
    {
        return $this->belongsTo('App\Entry');
    }

    /**
     * Get the user that this comment belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

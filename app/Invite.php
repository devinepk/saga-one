<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    /**
     * Get the user that sent this invite
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    /**
     * Get the journal that this invitation is for
     */
    public function journal()
    {
        return $this->belongsTo('App\Journal');
    }
}

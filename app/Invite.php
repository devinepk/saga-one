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
}

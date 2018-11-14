<?php

namespace App;

use App\Events\InviteDeclined;
use App\Notifications\InviteNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invite extends Model
{
    use Notifiable;

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

    /**
     * Send the invite notification.
     *
     * @return void
     */
    public function sendInviteNotification()
    {
        $this->notify(new InviteNotification);
    }

    /**
     * Mark the invite as declined.
     *
     * @return void
     */
    public function decline()
    {
        $this->declined_at = now();
        $this->save();

        // Trigger an event.
        event(new InviteDeclined);
    }
}

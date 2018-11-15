<?php

namespace App;

use App\Events\InviteDeclined;
use App\Events\InviteAccepted;
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
     * Get the user account associated with this invite
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
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

    /**
     * Mark the invite as accepted.
     *
     * @return void
     */
    public function accept()
    {
        $this->accepted_at = now();
        $this->save();

        // Add the user to the journal
        $this->journal->users()->attach($this->user);

        // Trigger an event.
        event(new InviteAccepted($this));
    }
}

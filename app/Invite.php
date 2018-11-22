<?php

namespace App;

use App\Comment;
use App\Entry;
use App\Journal;
use App\User;
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
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the journal that this invitation is for
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    /**
     * Get the user account associated with this invite
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        $this->journal->appendToQueue($this->user);

        // Trigger an event.
        event(new InviteAccepted($this));
    }
}

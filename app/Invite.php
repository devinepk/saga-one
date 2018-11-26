<?php

namespace App;

use App\Comment;
use App\Entry;
use App\Journal;
use App\User;
use App\Events\InviteDeclined as InviteDeclinedEvent;
use App\Events\InviteAccepted as InviteAcceptedEvent;
use App\Notifications\InviteAccepted as InviteAcceptedNotification;
use App\Notifications\InviteDeclined as InviteDeclinedNotification;
use App\Notifications\UserInvited;
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
        if ($this->user) {
            // If this invite is for a current user, then notify that user
            $this->user->notify(new UserInvited($this));
        } else {
            // If the invite is for someone who is not a current user,
            // then send a GuestInvite
            dd('no user found');
        }
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
        event(new InviteDeclinedEvent);

        // Notify the sender of declination
        $this->sender->notify(new InviteDeclinedNotification($this));
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
        event(new InviteAcceptedEvent($this));

        // Notify the sender of acceptance
        $this->sender->notify(new InviteAcceptedNotification($this));
    }
}

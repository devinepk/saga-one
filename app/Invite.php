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
use App\Notifications\GuestInvited;
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
            $this->notify(new GuestInvited);
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

        // Mark the invite notification as read
        $this->markInviteNotificationAsRead();
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

        // Mark the invite notification as read
        $this->markInviteNotificationAsRead();
    }

    /**
     * Mark the invite notification as read.
     *
     * @return void
     */
    public function markInviteNotificationAsRead()
    {
        // First find the notification
        // (can't directly query json values in the data field of the notifications table)
        $notification = $this->user->unreadNotifications()
            ->where('type', UserInvited::class)->get()
            ->firstWhere('data.invite_id', $this->getKey());

        // If the user was invited as a guest then there will be a GuestInvited notification,
        // not a UserInvited notification. We don't show GuestInvited notifications in the
        // database, so just ignore it.
        if ($notification) {
            $notification->markAsRead();
        }
    }
}

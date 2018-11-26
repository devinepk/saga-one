<?php

namespace App\Notifications;

use App\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserInvited extends Notification implements ShouldQueue
{
    use Queueable;

    public $invite;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("You have been invited to join {$this->invite->journal->title}")
            ->greeting("Guess what, {$notifiable->name}!")
            ->line("{$this->invite->sender->name} has invited you to join {$this->invite->journal->title} on SagaOne!")
            ->line('To view this invitation and join this journal, click the button below.')
            ->action(
                    'Join ' . $this->invite->journal->title,
                    $this->inviteUrl($this->invite)
                )
            ->salutation('Happy writing!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'sender' => $this->invite->sender->name,
            'journal' => $this->invite->journal->title,
            'invite_id' => $this->invite->id
        ];
    }

    /**
     * Get the invite URL for the given notifiable.
     *
     * @param  \App\Invite
     * @return string
     */
    protected function inviteUrl(Invite $invite)
    {
        return URL::signedRoute(
            'invite.verify', ['id' => $invite->getKey()]
        );
    }
}

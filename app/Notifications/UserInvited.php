<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserInvited extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // If the user already has an account, then use the name they set in their account.
        $greeting = ( $notifiable->user ? "Guess what, {$notifiable->user->name}!" : "Guess what!" );

        return (new MailMessage)
            ->subject("You have been invited to join {$notifiable->journal->title}")
            ->greeting($greeting)
            ->line("{$notifiable->sender->name} has invited you to join {$notifiable->journal->title} on SagaOne!")
            ->line('To view this invitation and join this journal, click the button below.')
            ->action(
                    'Join ' . $notifiable->journal->title,
                    $this->inviteUrl($notifiable)
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
        //
    }

    /**
     * Get the invite URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function inviteUrl($notifiable)
    {
        return URL::signedRoute(
            'invite.verify', ['id' => $notifiable->getKey()]
        );
    }
}

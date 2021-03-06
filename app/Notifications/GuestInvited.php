<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class GuestInvited extends Notification implements ShouldQueue
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
        return ['mail'];
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
            ->subject("You have been invited to join {$notifiable->journal->title}")
            ->greeting("Guess what!")
            ->line("{$notifiable->sender->name} has invited you to join {$notifiable->journal->title} on SagaOne!")
            ->line("SagaOne is a communal journal app that makes it easy for you to share your life with a small group of friends.")
            ->line('To create an account and join this journal, click the button below.')
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
        return [
            //
        ];
    }

    /**
     * Get the invite URL for the given notifiable.
     *
     * @param  mixed $notifiable
     * @return string
     */
    protected function inviteUrl($notifiable)
    {
        return URL::signedRoute(
            'invite.verify', ['id' => $notifiable->getKey()]
        );
    }
}

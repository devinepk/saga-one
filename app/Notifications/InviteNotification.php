<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteNotification extends Notification
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
                    ->line($notifiable->sender->name . ' has invited you to join a journal on SagaOne!')
                    ->line('Journal title: ' . $notifiable->journal->title)
                    ->line('To accept this invitation and join this journal, click the button below.')
                    ->action(
                        'Join "' . $notifiable->journal->title . '"',
                        $this->inviteUrl($notifiable)
                    )
                    ->line('Happy writing!');
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
     * @param  mixed  $notifiable
     * @return string
     */
    protected function inviteUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'invite.verify', Carbon::now()->addHours(12), ['id' => $notifiable->getKey()]
        );
    }
}

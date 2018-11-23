<?php

namespace App\Notifications;

use App\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteDeclined extends Notification
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
                    ->error()
                    ->subject("{$this->invite->user->name} has declined your invitation")
                    ->line("{$this->invite->user->name} has declined your invitation to join the journal called {$this->invite->journal->title}.")
                    ->line("To invite others to this journal (or resend this invite), click the button below.")
                    ->action(
                        "Invite others to {$this->invite->journal->title}",
                        route('journal.settings', $this->invite->journal)
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
}
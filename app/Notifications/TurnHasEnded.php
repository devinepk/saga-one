<?php

namespace App\Notifications;

use App\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TurnHasEnded extends Notification implements ShouldQueue
{
    use Queueable;

    public $journal;

    /**
     * Create a new notification instance.
     *
     * @param \App\Journal
     * @return void
     */
    public function __construct(Journal $journal)
    {
        $this->journal = $journal;
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
            ->subject("Your turn has ended with {$this->journal->title}")
            ->line("Your turn with the journal {$this->journal->title} has ended. This journal has moved on to {$this->journal->next_user->name}.")
            ->line("Any entries you wrote while you had this journal have been permanently added to it.")
            ->line("You'll be able to read and write in this journal again when it's your turn.")
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
            'journal' => $this->journal->title,
            'next_user' => $this->journal->next_user->name
        ];
    }
}

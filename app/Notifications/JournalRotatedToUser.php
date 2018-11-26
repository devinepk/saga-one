<?php

namespace App\Notifications;

use App\Journal;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JournalRotatedToUser extends Notification implements ShouldQueue
{
    use Queueable;

    public $journal;

    /**
     * Create a new notification instance.
     *
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
            ->subject("It's your turn to write in {$this->journal->title}")
            ->greeting("Greetings, {$notifiable->name}!")
            ->line("It's your turn to write in {$this->journal->title}!")
            ->line("You will be able to read and write in this journal until {$this->journal->formatted_next_change}.")
            ->action(
                    'Go to ' . $this->journal->title,
                    route('journal.show', $this->journal)
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
            'journal' => $this->journal->title,
            'next_change' => $this->journal->formatted_next_change
        ];
    }
}

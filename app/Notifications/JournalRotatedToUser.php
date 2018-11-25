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
        $formatted_next_change = (new Carbon($notifiable->next_change, config('timezone', 'America/New_York')))
                                    ->format('F jS \\a\\t g:ia');

        return (new MailMessage)
            ->subject("It's your turn to write in {$notifiable->title}")
            ->greeting("Greetings, {$notifiable->current_user->name}!")
            ->line("It's your turn to write in {$notifiable->title}!")
            ->line("You will be able to read and write in this journal until {$formatted_next_change}.")
            ->action(
                    'Go to ' . $notifiable->title,
                    route('journal.show', $notifiable)
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

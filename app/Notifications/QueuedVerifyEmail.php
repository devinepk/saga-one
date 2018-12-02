<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class QueuedVerifyEmail extends VerifyEmail implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | QueuedVerifyEmail
    |--------------------------------------------------------------------------
    |
    | This notification makes the default Laravel VerifyEmail notification
    | queueable.
    |
    | The ::toMail() method is also customized.
    |
    */
    use Queueable;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Please verify your email address')
                ->greeting("Nice to meet you, {$notifiable->name}!")
                ->line('Thank you for registering for SagaOne! Please click the button below to verify your email address.')
                ->action('Verify Email Address', $this->verificationUrl($notifiable))
                ->line('If you did not create an account, you may disregard this email.');
    }
}

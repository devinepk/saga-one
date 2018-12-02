<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class QueuedResetPassword extends ResetPassword implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | QueuedResetPassword
    |--------------------------------------------------------------------------
    |
    | This notification makes the default Laravel ResetPassword notification
    | queueable. Everything else is the same.
    |
    */

    use Queueable;
}

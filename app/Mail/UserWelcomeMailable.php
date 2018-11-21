<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserWelcomeMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user who has just registered
     *
     * @var \App\User
     **/
    public $user;

    /**
     * Create a new message instance.
     *
     * @param \App\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to SagaOne!')
                    ->view('emails.welcome', ['user' => $this->user]);
    }
}

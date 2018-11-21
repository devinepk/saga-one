<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class VerifyEmailMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user who must verify email
     *
     * @var \App\User
     **/
    public $user;

    /**
     * The signed URL for this verification
     *
     * @var \App\User
     **/
    public $verificationUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->verificationUrl = URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['id' => $user->getKey()]
        );
}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Please verify your email address')
                    ->view('emails.verifyEmail', [
                        'user' => $this->user,
                        'verificationUrl' => $this->verificationUrl
                    ]);
    }
}

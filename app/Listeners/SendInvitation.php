<?php

namespace App\Listeners;

use App\Events\UserInvited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvitation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserInvited  $event
     * @return void
     */
    public function handle(UserInvited $event)
    {
        // access user with $event->user
    }
}

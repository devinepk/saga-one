<?php

namespace App\Listeners;

use App\Events\InviteAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAcceptedNotification
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
     * @param  InviteAccepted  $event
     * @return void
     */
    public function handle(InviteAccepted $event)
    {
        //
    }
}

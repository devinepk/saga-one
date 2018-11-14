<?php

namespace App\Listeners;

use App\Events\InviteDeclined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDeclinedNotification
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
     * @param  InviteDeclined  $event
     * @return void
     */
    public function handle(InviteDeclined $event)
    {
        //
    }
}

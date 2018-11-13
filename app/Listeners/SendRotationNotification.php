<?php

namespace App\Listeners;

use App\Events\JournalRotated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRotationNotification
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
     * @param  JournalRotated  $event
     * @return void
     */
    public function handle(JournalRotated $event)
    {
        //
    }
}

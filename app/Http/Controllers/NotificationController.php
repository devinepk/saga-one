<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{

    /**
     * Mark a notification as read
     *
     * @param  \Illuminate\Notifications\DatabaseNotification
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(DatabaseNotification $notification) {
        $notification->markAsRead();
        return $notification;
    }
}

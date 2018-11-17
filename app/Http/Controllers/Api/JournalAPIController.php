<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Journal;
use App\User;
use Illuminate\Http\Request;

class JournalAPIController extends Controller
{
    /**
     * Add an entry to the journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function updateQueue(Request $request, Journal $journal) {
        return "Updating the queue in the JournalAPIController";
    }
}

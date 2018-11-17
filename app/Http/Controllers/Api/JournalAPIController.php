<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Journal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalAPIController extends Controller
{
    /**
     * Process an API request to update a journal's queue
     *
     * The new queue can be accessed with $request->input('new_queue') and will
     * take the form of an indexed array of strings of the form "userX",
     * where X is the user id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function updateQueue(Request $request, Journal $journal) {
        // Extract the user ids
        $users = array_map(function($user) {
            // Trim off 4 chars to erase the "user" prefix
            return substr($user, 4);
        }, $request->input('new_queue'));

        $records = DB::table('journal_user')->select('user_id', 'next_user_id')->where('journal_id', 2)->get();

        $old = [];
        foreach ($records as $record) {
            $old[$record->user_id] = $record->next_user_id;
        }

        // First, erase the old 'next_user_id' value so we don't violate
        // any unique indexes.
        foreach ($users as $user) {
            $journal->users()->updateExistingPivot($user, ['next_user_id' => null]);
        }

        $new = [];
        // Update the 'next_user_id' field for each user
        for ($i = 0; $i < count($users); $i++) {

            $current_user_id = $users[$i];

            // Wrap the counter around to the beginning of the array if necessary
            // (The first user in line will follow the last person in line.)
            $next_user_index = ($i + 1) % count($users);
            $next_user_id = $users[$next_user_index];

            $new[$current_user_id] = $next_user_id;
            $journal->users()->updateExistingPivot($current_user_id, ['next_user_id' => $next_user_id]);
        }

        return ['old' => $old, 'new' => $new];
    }
}

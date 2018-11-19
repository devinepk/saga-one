<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Entry;
use App\Journal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentAPIController extends Controller
{
    /**
     * Process an API request to add a comment to an entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Entry $entry)
    {
        return 'Adding a comment...';
    }
}

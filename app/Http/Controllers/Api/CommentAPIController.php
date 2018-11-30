<?php

namespace App\Http\Controllers\Api;

use App\Comment;
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
        // No validation necessary as message is a text field
        $comment = new Comment;
        $comment->message = htmlspecialchars($request->input('message'));
        $comment->user()->associate(Auth::user());
        $entry->comments()->save($comment);

        // Return an updated set of comments for this entry
        return $entry->comments()->with('user')->get()->toJson();
    }

    /**
     * Process an API request to delete a comment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Comment $comment)
    {
        $comment->delete();
    }

    /**
     * Process an API request to update a comment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        if ($request->user == $comment->user_id) {
            $comment->message = $request->message;
            $comment->save();
        } else {
            abort(403);
        }
    }
}

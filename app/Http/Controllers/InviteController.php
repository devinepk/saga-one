<?php

namespace App\Http\Controllers;

use App\Invite;
use App\User;
use Illuminate\Http\Request;
use App\Events\InviteAccepted;

class InviteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Invite Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the verification of journal
    | invites.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invite $invite
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $id) {
        $invite = Invite::find($id);
        // dd($request, $invite);

        // Is there a user with this email address in the system already?
        if ($user = User::where('email', $invite->email)->first()) {
            // Add the user to the journal
            $user->journals()->attach($invite->journal->id);

            // Trigger an event
            event(new InviteAccepted($invite));

            // Mark the invitation as accepted
            $invite->accepted_at = now();
            $invite->save();

            // Redirect to journal.index
            return redirect()
                ->route('journal.index')
                ->with('status', "You have joined <strong>{$invite->journal->title}</strong>.");
        }



        // If not, redirect to the registration form???
        return 'You need to sign up first...';
    }

    /**
     * Resend the journal invite.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}

<?php

namespace App\Http\Controllers;

use App\Invite;
use App\User;
use Illuminate\Http\Request;
use App\Events\InviteAccepted;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('auth')->only('show', 'decline');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Invite $invite)
    {
        $journal = $invite->journal;
        return view('invite.show', compact('invite', 'journal'));
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $id the invite id
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $id) {
        $invite = Invite::find($id);
        // dd($request, $invite);

        // Is there a user with this email address in the system already?
        if ($user = User::where('email', $invite->email)->first()) {
            if (Auth::id() != $user->id) {
                // If this user isn't currently logged in, then log out the current user.
                Auth::logout();
            }

            return redirect()->route('invite.show', $invite);


        }

        // Register the user AND add them to the journal.




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

    public function attachUserToJournal(Request $request, User $user) {
        // Add the user to the journal
        $user->journals()->attach($invite->journal->id);

        // Trigger an event
        event(new InviteAccepted($invite));

        // Mark the invitation as accepted
        $invite->accepted_at = now();
        $invite->save();

        // Redirect to journal.index
        // TODO: FLASH MESSAGE DOESN'T WORK
        return redirect()
            ->route('journal.index')
            ->with('status', "You have joined <strong>{$invite->journal->title}</strong>.");
    }

    /**
     * Decline an invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function decline(Request $request, Invite $invite)
    {
        if (Auth::user()->can('view', $invite)) {
            // Mark the invite as declined.
            $invite->decline();

            // Redirect to journal index with a message.
            return redirect()
                ->route('journal.index')
                ->with('status', "You have declined the invitation to join <strong>{$invite->journal->title}</strong>.");
        }
    }
}

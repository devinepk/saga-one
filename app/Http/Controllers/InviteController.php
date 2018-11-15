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
    | This controller is responsible for handling journal invites.
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
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function show(Invite $invite)
    {
        if (Auth::user()->can('view', $invite)) {
            $journal = $invite->journal;
            return view('invite.show', compact('invite', 'journal'));
        }

        return back();
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
     * @return \Illuminate\Http\Response
     */
    public function resend(Invite $invite)
    {
        // If the invite has already been accepted, then redirect with messaging.
        if ($invite->accepted_at) {
            return back()->with('status', 'This invite has already been accepted.');
        }

        // Mark the invite as undeclined
        $invite->declined_at = null;
        $invite->save();

        // Resend the invite
        $invite->sendInviteNotification();
        return back()->with('invite_resent', "A fresh invite has been sent to <strong>{$invite->name}</strong> at <strong>{$invite->email}</strong>.");
    }

    /**
     * Decline an invitation.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function decline(Invite $invite)
    {
        if (Auth::user()->can('view', $invite)) {
            // dd('User is allowed to decline an invite');
            // Mark the invite as declined.
            $invite->decline();

            // Redirect to journal index with a message.
            return redirect()
                ->route('journal.index')
                ->with('status', "You have declined {$invite->sender->name}'s invitation to join <strong>{$invite->journal->title}</strong>.");
        }

        return back();
    }

    /**
     * Accept an invitation.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function accept(Invite $invite)
    {
        if (Auth::user()->can('view', $invite)) {
            // Mark the invite as accepted.
            $invite->accept();

            // Redirect to journal index with a message.
            // TODO: THIS FLASH MESSAGE DOESN'T PERSIST THROUGH AUTHENTICATION.
            return redirect()
                ->route('journal.index')
                ->with('status', "You have accepted {$invite->sender->name}'s invitation to join <strong>{$invite->journal->title}</strong>! Happy writing!");
        }

        return back();
    }
}

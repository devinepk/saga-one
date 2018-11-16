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
        $this->middleware('auth')->except('verify');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show all pending invitations for the current user.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending_invites = Auth::user()->invites_received()->where([
            ['accepted_at', null],
            ['declined_at', null]
        ])->with(['journal', 'sender'])->get();

        $accepted_invites = Auth::user()->invites_received()->where([
            ['accepted_at', '<>', null]
        ])->with(['journal', 'sender'])->get();

        $declined_invites = Auth::user()->invites_received()->where([
            ['declined_at', '<>', null]
        ])->with(['journal', 'sender'])->get();

        return view('invite.index', compact('pending_invites', 'accepted_invites', 'declined_invites'));
    }

    /**
     * Show the invitation.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function show(Invite $invite)
    {
        $this->authorize('view', $invite);
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

        // Is there a user with this email address in the system already?
        if ($user = User::where('email', $invite->email)->first()) {

            if (Auth::id() != $user->id) {
                // If this user isn't currently logged in, then log out the current user.
                Auth::logout();
                // Add a flag to the session and redirect to the login screen
                $request->session()->put('invite', $id);
                return redirect()->route('login');
            }

            // Otherwise just show them the invite.
            return redirect()->route('invite.show', $invite);
        }

        // This is a new user.
        // Log out any current user if one is logged in
        if (Auth::check()) {
            Auth::logout();
        }

        // Add a flag to the session
        $request->session()->put('invite', $id);

        // Send the user to the registration form
        return redirect()->route('register');
    }

    /**
     * Resend the journal invite.
     *
     * @return \Illuminate\Http\Response
     */
    public function resend(Invite $invite)
    {
        if (Auth::user()->can('view', $invite) && $invite->accepted_at) {
            // If the invite has already been accepted, then redirect with messaging.
            return redirect()->route('journal.settings', $invite->journal)
                ->with('status', 'This invite has already been accepted.');
        }

        $this->authorize('resend', $invite);

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
        $this->authorize('view', $invite);

        // Mark the invite as declined.
        $invite->decline();

        // Redirect to journal index with a message.
        return redirect()->route('journal.index')
            ->with('status', "You have declined {$invite->sender->name}'s invitation to join <strong>{$invite->journal->title}</strong>.");
    }

    /**
     * Accept an invitation.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function accept(Invite $invite)
    {
        $this->authorize('view', $invite);

        // Mark the invite as accepted.
        $invite->accept();

        // Add a flag to the session and redirect to the journal index.
        return redirect()->route('journal.index')
            ->with('status', "You have accepted {$invite->sender->name}'s invitation to join <strong>{$invite->journal->title}</strong>! Happy writing!");
    }

    /**
     * Delete an invitation.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function delete(Invite $invite)
    {
        $this->authorize('delete', $invite);

        // Delete the invite (for real) and redirect
        $invite->delete();
        return redirect()->route('journal.settings', $invite->journal)
            ->with('status', "Invite deleted.");
    }
}

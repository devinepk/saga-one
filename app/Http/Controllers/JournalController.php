<?php

namespace App\Http\Controllers;

use App\User;
use App\Journal;
use App\Invite;
use App\Events\UserInvited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class JournalController extends Controller
{
    /**
     * Require authentication
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Package journals with the user's current journals at the
        // beginning and archived journals at the end.
        $journals = [];
        foreach (Auth::user()->current_journals as $journal) {
            $journals[] = $journal;
        }
        foreach (Auth::user()->other_journals as $journal) {
            $journals[] = $journal;
        }
        foreach (Auth::user()->journals()->where('active', 'false')->get() as $journal) {
            $journals[] = $journal;
        }
        return view('journal.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('create', Journal::class)) {
            return view('journal.create');
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create', Journal::class)) {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'nullable|max:255'
            ]);

            $journal = new Journal;
            $journal->title = $request->title;
            $journal->description = $request->description;
            $journal->current_user()->associate(Auth::id());
            $journal->creator()->associate(Auth::id());

            $journal->save();
            $journal->users()->save(Auth::user());

            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been created.");
            return redirect()->route('journal.show', compact('journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Show the page for where entries can be added to the journal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Journal $journal)
    {
        // Show the journal if the user has permission
        if (Auth::user()->can('addEntry', $journal)) {
            $drafts = $journal->entries()->where('status', 'draft')->paginate(5);
            $drafts->withPath(route('journal.show', $journal));

            return view('journal.show', compact('journal', 'drafts'));
        }

        if (Auth::user()->isInJournal($journal)) {
            if ($journal->active) {
                // Show a flash message if the user belongs to the journal.
                $request->session()->flash('status', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to view it when it's your turn.");
            } else {
                // Redirect to the contents page
                return redirect()->route('journal.contents', $journal);
            }
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Show the journal settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request, Journal $journal)
    {
        if (Auth::user()->can('viewSettings', $journal)) {
            return view('journal.settings', compact('journal'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            $request->session()->flash('status', "Only {$journal->creator->name} can edit the settings for <strong>{$journal->title}</strong>.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        if (Auth::user()->can('update', $journal)) {
            $request->validate([
                'title' => 'sometimes|required|max:255',
                'description' => 'nullable|max:255'
            ]);

            if ($request->has('title')) {
                $journal->title = $request->title;
            }

            if ($request->has('description')) {
                $journal->description = $request->description;
            }

            if ($request->has('period')) {
                $journal->period = $request->period;
                $journal->next_change = now()->addSeconds($request->period);
            }

            $journal->save();

            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been updated.");
            return redirect()->route('journal.settings', compact('journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Archive the journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function archive(Request $request, Journal $journal)
    {
        if (Auth::user()->can('archive', $journal)) {
            // If active, then archive
            if ($journal->active) {
                $journal->active = false;
                $journal->current_user()->dissociate();
                $journal->save();

                $request->session()->flash('status', "<strong>{$journal->title}</strong> has been archived.");
            } else {
                // If inactive, then unarchive
                $journal->active = true;
                $journal->current_user()->associate(Auth::user());
                $journal->save();

                $request->session()->flash('status', "<strong>{$journal->title}</strong> has been unarchived and is now in your possession.");
            }
            return redirect()->route('journal.settings', $journal);
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Remove the journal from storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Journal $journal)
    {
        if (Auth::user()->can('delete', $journal)) {

            $journal->delete();
            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been deleted.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Un-archive a journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, Journal $journal)
    {
        if (Auth::user()->can('restore', $journal)) {

            $journal->active = true;
            $journal->save();

            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been restored from the archive.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Process an invitation to join a journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request, Journal $journal)
    {
        if (Auth::user()->can('invite', $journal)) {

            $request->validate([
                'name'  => 'required|max:255',
                'email' => 'required|email'
            ]);

            $invite = new Invite;
            $invite->name = $request->name;
            $invite->email = $request->email;

            // Does this user already have an account? If so, associate it.
            if ($user = User::where('email', $request->email)->first()) {
                $invite->user()->associate($user);
            }

            $invite->sender()->associate(Auth::user());
            $invite->journal()->associate($journal);
            Auth::user()->invites_sent()->save($invite);
            $invite->sendInviteNotification();
            event(new UserInvited($invite));
            $request->session()->flash('status', "An invitation to join <strong>{$journal->title}</strong> will be sent to <strong>{$invite->name}</strong> at <strong>{$invite->email}</strong>.");
            return redirect()->route('journal.settings', compact('journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Display all the entries in a journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function contents(Request $request, Journal $journal)
    {
        if (Auth::user()->can('view', $journal)) {
            $entries = $journal->entries()->where('status', 'final')->paginate(10);
            $entries->withPath(route('journal.contents', $journal));

            return view('entry.index', compact('journal', 'entries'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            $request->session()->flash('warning', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to read it when it's your turn.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Display all the entries in a journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Journal $journal) {
        if (Auth::user()->can('addEntry', $journal)) {
            return view('entry.create', compact('journal'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            $request->session()->flash('status', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to write in it when it's your turn.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }
}

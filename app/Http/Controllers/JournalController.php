<?php

namespace App\Http\Controllers;

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
                'title' => 'required|max:255'
            ]);

            $journal = new Journal;
            $journal->title = $request->title;
            $journal->description = $request->description;
            $journal->creator_id = $journal->current_user_id = Auth::id();
            $journal->save();
            $journal->users()->save(Auth::user());

            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been created.");
            return redirect()->route('journal.show', compact('journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Journal $journal)
    {
        // Show the journal to the current user only.
        if (Auth::user()->can('view', $journal)) {
            $drafts = $journal->entries()->where('status', 'draft')->paginate(5);
            $drafts->withPath(route('journal.show', $journal));

            return view('journal.show', compact('journal', 'drafts'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            $request->session()->flash('status', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to view it when it's your turn.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Journal $journal)
    {
        // Only the journal creator can edit journal details
        if (Auth::user()->can('update', $journal)) {
            return view('journal.edit', compact('journal'));
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
                'title' => 'required|max:255'
            ]);

            $journal->title = $request->title;
            $journal->description = $request->description;
            $journal->save();

            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been updated.");
            return redirect()->route('journal.show', compact('journal'));
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

            $journal->active = false;
            $journal->save();

            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been archived.");
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
     * Display journal invitation form
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function invite(Journal $journal)
    {
        if (Auth::user()->can('invite', $journal)) {
            return view('journal.invite', compact('journal'));
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
    public function processInvite(Request $request, Journal $journal)
    {
        if (Auth::user()->can('invite', $journal)) {

            $request->validate([
                'name'  => 'required|max:255',
                'email' => 'required|email'
            ]);

            $invite = new Invite;
            $invite->name = $request->name;
            $invite->email = $request->email;

            $invite->sender()->associate(Auth::user());
            $invite->journal()->associate($journal->id);
            Auth::user()->invites()->save($invite);
            event(new UserInvited($invite));

            $request->session()->flash('status', "An invitation to join <strong>{$journal->title}</strong> will be sent to <strong>{$invite->name}</strong> using the email address you provided.");
            return view('journal.invite', compact('journal'));
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
            $request->session()->flash('status', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to read it when it's your turn.");
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

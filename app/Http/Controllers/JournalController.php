<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('journal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('journal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Validate the request

        $journal = new Journal;
        $journal->title = $request->title;
        $journal->description = $request->description;
        $journal->creator_id = $journal->current_user_id = Auth::id();
        $journal->save();
        $journal->users()->save(Auth::user());

        $request->session()->flash('status', "<strong>{$journal->title}</strong> has been created.");
        return redirect()->route('journal.show', compact('journal'));
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
        if (Auth::id() == $journal->current_user->id) {
            $drafts = $journal->entries()->where('status', 'draft')->get()->sortByDesc('created_at');
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
        if (Auth::id() == $journal->creator->id) {
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
        // TODO: Validate the request

        $journal->title = $request->title;
        $journal->description = $request->description;
        $journal->save();

        $request->session()->flash('status', "<strong>{$journal->title}</strong> has been updated.");
        return redirect()->route('journal.show', compact('journal'));
    }

    /**
     * Perform a soft delete
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Journal $journal)
    {
        // TODO: Validate request

        $journal->delete();
        $request->session()->flash('status',
            "<strong>{$journal->title}</strong> has been deleted.
            <a href=\"#\" onclick=\"event.preventDefault(); document.getElementById('undo-form').submit();\">Undo</a>
            <form id=\"undo-form\" style=\"display:none;\" method=\"post\" action='/journal/undodelete'>
                <input type='hidden' name='_token' value='" . csrf_token() . "'>
                <input type='hidden' name='journal_id' value='{$journal->id}'>
            </form>"
        );
        return redirect()->route('journal.index');
    }

    /**
     * Show a confirmation for performing a soft delete
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Journal $journal)
    {
        // TODO: Validate request

        return view('journal.confirmDelete', compact('journal'));
    }

    /**
     * Reverse a soft delete
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function undoDelete(Request $request)
    {
        // TODO: Validate request

        $journal = \App\Journal::withTrashed()->find($request->input('journal_id'));
        $journal->restore();
        $request->session()->flash('status', "<strong>{$journal->title}</strong> has been restored.");
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
        // TODO: Validate request

        return view('journal.invite', compact('journal'));
    }

    /**
     * Display all the entries in a journal
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function contents(Journal $journal)
    {
        // TODO: Validate request

        $entries = $journal->entries()->where('status', 'final')->get()->sortByDesc('created_at');

        return view('entry.index', compact('journal', 'entries'));
    }
}

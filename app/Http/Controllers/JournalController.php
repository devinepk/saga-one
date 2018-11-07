<?php

namespace App\Http\Controllers;

use App\Journal;
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
        return view('journal.index');
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
     * Perform a soft delete
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Journal $journal)
    {
        if (Auth::user()->can('delete', $journal)) {

            $journal->delete();
            $request->session()->flash('status',
                "<strong>{$journal->title}</strong> has been deleted.
                <a href=\"#\" onclick=\"event.preventDefault(); document.getElementById('undo-form').submit();\">Undo</a>
                <form id=\"undo-form\" style=\"display:none;\" method=\"post\" action='/journal/undodelete'>
                    <input type='hidden' name='_token' value='" . csrf_token() . "'>
                    <input type='hidden' name='journal_id' value='{$journal->id}'>
                </form>"
            );
        }

        // Redirect to journal index
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
        if (Auth::user()->can('delete', $journal)) {

            return view('journal.confirmDelete', compact('journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Reverse a soft delete
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function undoDelete(Request $request)
    {
        if (Auth::user()->can('restore', $journal)) {

            $journal = \App\Journal::withTrashed()->find($request->input('journal_id'));
            $journal->restore();
            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been restored.");
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
     * Display all the entries in a journal
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function contents(Journal $journal)
    {
        if (Auth::user()->can('view', $journal)) {
            $entries = $journal->entries()->where('status', 'final')->paginate(2);
            $entries->withPath(route('journal.contents', $journal));

            return view('entry.index', compact('journal', 'entries'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            $request->session()->flash('status', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to view it when it's your turn.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Display all the entries in a journal
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function addEntry(Journal $journal) {
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

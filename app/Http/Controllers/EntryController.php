<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{

    /**
     * Require authentication
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Use route journal.addEntry instead
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Journal $journal)
    {
        if (Auth::user()->can('create', Entry::class)) {
            $request->validate([
                'title' => 'nullable|max:512'
            ]);

            $entry = new Entry;
            $entry->title = $request->title ? $request->title : '[Untitled]';
            $entry->body = $request->body;
            $entry->status = 'draft';
            $entry->author()->associate(Auth::user());

            $journal = Journal::find($request->journal_id);
            $journal->entries()->save($entry);

            $request->session()->flash('status', "<strong>{$entry->title}</strong> has been saved.");
        }
        return redirect()->route('journal.show', compact('journal'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @param \App\Journal $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry, Journal $journal)
    {
        if (Auth::user()->can('view', $entry)) {
            $nextEntry = $journal->getEntryAfter($entry);
            $previousEntry = $journal->getEntryBefore($entry);
            return view('entry.show', compact('entry', 'journal', 'nextEntry', 'previousEntry'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            $request->session()->flash('status', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to read it when it's your turn.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entry  $entry
     * @param \App\Journal $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry, Journal $journal)
    {
        if (Auth::user()->can('update', $entry)) {
            return view('entry.edit', compact('entry', 'journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @param \App\Journal $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry, Journal $journal)
    {
        if (Auth::user()->can('update', $entry)) {
            $request->validate([
                'title' => 'nullable|max:512'
            ]);
            $entry->body = $request->body;
            $entry->title = $request->title;
            $entry->save();

            $request->session()->flash('status', "<strong>{$entry->title}</strong> has been saved.");
            return redirect()->route('journal.show', compact('journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Perform a soft delete
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @param \App\Journal $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Entry $entry, Journal $journal)
    {
        if (Auth::user()->can('delete', $entry)) {
            $entry->delete();
            $request->session()->flash('status',
                "<strong>{$entry->title}</strong> has been deleted.
                <a href=\"#\" onclick=\"event.preventDefault(); document.getElementById('undo-form').submit();\">Undo</a>
                <form id=\"undo-form\" class=\"d-none\" method=\"post\" action='/entry/undodelete'>
                    <input type='hidden' name='_token' value='" . csrf_token() . "'>
                    <input type='hidden' name='entry_id' value='{$entry->id}'>
                </form>"
            );
        }

        return redirect()->route('journal.show', compact('journal'));
    }

    /**
     * Reverse a soft delete
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function undoDelete(Request $request)
    {
        if (Auth::user()->can('restore', $entry)) {
            $entry = Entry::withTrashed()->find($request->input('entry_id'));
            $entry->restore();
            $request->session()->flash('status', "<strong>{$entry->title}</strong> has been restored.");
            $journal = $entry->journal;
        }

        return redirect()->route('journal.show', compact('journal'));
    }
}

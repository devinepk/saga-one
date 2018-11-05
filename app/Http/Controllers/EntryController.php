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
        // TODO: Validate request
        $nextEntry = $journal->getEntryAfter($entry);
        $previousEntry = $journal->getEntryBefore($entry);
        return view('entry.show', compact('entry', 'journal', 'nextEntry', 'previousEntry'));
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

        if ($entry->status == 'draft') {
            return view('entry.edit', compact('entry', 'journal'));
        }
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
        $request->validate([
            'title' => 'nullable|max:512'
        ]);
        $entry->body = $request->body;
        $entry->title = $request->title;
        $entry->save();

        $request->session()->flash('status', "<strong>{$entry->title}</strong> has been saved.");
        return redirect()->route('journal.show', compact('journal'));
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
        $entry->delete();
        $request->session()->flash('status',
            "<strong>{$entry->title}</strong> has been deleted.
            <a href=\"#\" onclick=\"event.preventDefault(); document.getElementById('undo-form').submit();\">Undo</a>
            <form id=\"undo-form\" class=\"d-none\" method=\"post\" action='/entry/undodelete'>
                <input type='hidden' name='_token' value='" . csrf_token() . "'>
                <input type='hidden' name='entry_id' value='{$entry->id}'>
            </form>"
        );
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
        // TODO: Validate request

        $entry = Entry::withTrashed()->find($request->input('entry_id'));
        $entry->restore();
        $request->session()->flash('status', "<strong>{$entry->title}</strong> has been restored.");
        $journal = $entry->journal;
        return redirect()->route('journal.show', compact('journal'));
    }
}

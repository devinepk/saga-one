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
    public function store(Request $request)
    {
        $journal = Journal::find($request->journal_id);

        $entry = new Entry;
        $entry->title = $request->title ? $request->title : '[Untitled]';
        $entry->body = $request->body;
        $entry->journal_id = $journal->id;
        $entry->author_id = Auth::id();
        $entry->status = 'draft';
        $entry->save();

        $request->session()->flash('status', "<strong>{$entry->title}</strong> has been saved.");
        return redirect()->route('journal.show', compact('journal'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        // TODO: Validate request
        $journal = $entry->journal;
        $nextEntry = $journal->getEntryAfter($entry);
        $previousEntry = $journal->getEntryBefore($entry);
        return view('entry.show', compact('entry', 'journal', 'nextEntry', 'previousEntry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        if ($entry->status == 'draft') {
            $journal = $entry->journal;
            return view('entry.edit', compact('entry', 'journal'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        $entry->body = $request->body;
        $entry->title = $request->title;
        $entry->save();

        $journal = Journal::find($request->journal_id);

        $request->session()->flash('status', "<strong>{$entry->title}</strong> has been saved.");
        return redirect()->route('journal.show', compact('journal'));
    }

    /**
     * Perform a soft delete
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Entry $entry)
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
        return redirect()->route('journal.show');
    }
}

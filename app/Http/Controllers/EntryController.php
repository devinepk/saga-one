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

        if (Auth::user()->can('addEntry', $journal)) {
            $request->validate([
                'title' => 'nullable|max:512'
            ]);

            $entry = new Entry;
            $entry->title = $request->title ? $request->title : '[Untitled]';
            $entry->body = $request->body;
            $entry->status = 'draft';
            $entry->author()->associate(Auth::user());
            $journal->entries()->save($entry);

            $request->session()->flash('status', "<strong>{$entry->title}</strong> has been saved.");
            return redirect()->route('journal.show', compact('journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Entry $entry)
    {
        if (Auth::user()->can('view', $entry)) {
            $journal = $entry->journal;
            return view('entry.show', compact('entry', 'journal'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($entry->journal)) {
            $request->session()->flash('warning', "{$entry->journal->current_user->name} has <strong>{$entry->journal->title}</strong> right now. You'll be able to read it when it's your turn.");
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        if (Auth::user()->can('update', $entry)) {
            $journal = $entry->journal;
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        if (Auth::user()->can('update', $entry)) {
            $request->validate([
                'title' => 'nullable|max:512'
            ]);

            $entry->body = $request->body;
            $entry->title = $request->title;
            $entry->save();
            $request->session()->flash('status', "<strong>{$entry->title}</strong> has been saved.");
            $journal = $entry->journal;
            return redirect()->route('journal.show', compact('journal'));
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }

    /**
     * Remove the entry from storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Entry $entry)
    {
        if (Auth::user()->can('delete', $entry)) {
            $entry->delete();
            $request->session()->flash('status', "<strong>{$entry->title}</strong> has been deleted.");
        }
        $journal = $entry->journal;
        return redirect()->route('journal.show', compact('journal'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

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
        // Use route journal.add instead
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

        $this->authorize('addEntry', $journal);

        $request->validate([
            'title' => 'nullable|max:512'
        ]);

        $entry = new Entry;
        $entry->title = $request->title ? $request->title : '[Untitled]';
        $entry->body = $request->body;
        $entry->status = 'draft';
        $entry->author()->associate(Auth::user());
        $journal->entries()->save($entry);

        return redirect()->route('journal.show', compact('journal'))
            ->with('status', "<strong>{$entry->title}</strong> has been saved.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        if (Auth::user()->can('view', $entry)) {
            return view('entry.show', ['entry' => $entry, 'journal' => $entry->journal]);
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($entry->journal)) {
            return redirect()->route('journal.index')
                ->with('warning', "{$entry->journal->current_user->name} has <strong>{$entry->journal->title}</strong> right now. You'll be able to read it when it's your turn.");
        }

        // Otherwise throw exception
        throw new AuthorizationException;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        $this->authorize('update', $entry);
        return view('entry.edit', ['entry' => $entry, 'journal' => $entry->journal]);
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
        $this->authorize('update', $entry);

        $request->validate([
            'title' => 'nullable|max:512'
        ]);

        $entry->body = $request->body;
        $entry->title = $request->title;
        $entry->save();

        return redirect()->route('journal.show', ['journal' => $entry->journal])
            ->with('status', "<strong>{$entry->title}</strong> has been saved.");
    }

    /**
     * Remove the entry from storage
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $this->authorize('delete', $entry);

        $entry->delete();
        return redirect()->route('journal.show', ['journal' => $entry->journal])
            ->with('status', "<strong>{$entry->title}</strong> has been deleted.");
    }
}

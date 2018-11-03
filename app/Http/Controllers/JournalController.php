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
        $journals = Auth::user()->journals;
        return view('journal.index', compact('journals'));
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
            return view('journal.show', compact('journal'));
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
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        return view('journal.edit', compact('journal'));
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
        $entries = [
            ['title' => 'Entry 1', 'author' => 'Bobbert Bob', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...'],
            ['title' => 'Entry 2', 'author' => 'Bobby Bob', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...'],
            ['title' => 'Entry 3', 'author' => 'Bonnie Bobbington', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...'],
            ['title' => 'Entry 4', 'author' => 'Boris Bobford', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...'],
            ['title' => 'Entry 5', 'author' => 'Boris Bobford', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...']
        ];

        return view('journal.contents', compact('journal', 'entries'));
    }
}

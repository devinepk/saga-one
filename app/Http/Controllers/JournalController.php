<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;

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
        $journals = Journal::all();
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
        $journal->save();
        return redirect()->route('journal.show', compact('journal'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        return view('journal.show', compact('journal'));
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
        return redirect()->route('journal.show', compact('journal'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
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

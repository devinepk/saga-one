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

        // Load the queue for each journal
        foreach ($journals as $journal) {
            $journal->queue = $this->get_queue($journal);
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
     * Perform a soft delete
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        $journal->delete();
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


    /**
     * Get the queue of users that belong to this journal,
     * starting with the current user.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Support\Collection
     *
     * THERE IS PROBABLY A CLEARER WAY TO DO THIS...
     * The problem is that $this->current_user doesn't come preloaded
     * with info from the pivot table. But $this->users does...
     */
    public function get_queue(Journal $journal)
    {
        $queue = [];
        $user = $journal->users->search(function ($user, $key) use ($journal) {
            return $user->id == $journal->current_user->id;
        });
        $user = $journal->users->get($user);
        do {
            $queue[] = $user;
            $user = $this->next_user($journal, $user);
        } while ($user->id != $journal->current_user->id);

        return $queue;
    }

    /**
     * Utility function
     * Finds the next user in the queue for a given user
     *
     * @param \App\Journal $journal
     * @param \App\User $user
     * @return \App\User
     */
    public function next_user(Journal $journal, \App\User $user) {
        $temp_user = $journal->users->search(function ($item, $key) use ($user) {
            return $item->id == $user->id;
        });
        $temp_user = $journal->users->get($temp_user);

        $temp_user =  $journal->users->search(function ($item, $key) use ($temp_user) {
            return $item->id == $temp_user->subscription->next_user_id;
        });

        return $journal->users->get($temp_user);
    }
}

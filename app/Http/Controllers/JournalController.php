<?php

namespace App\Http\Controllers;

use App\Events\UserInvited;
use App\Http\Requests\StoreInvite;
use App\Invite;
use App\Journal;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Validator;

class JournalController extends Controller
{
    /**
     * Require authentication
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified')->only('invite');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Package journals with the user's current journals at the
        // beginning and archived journals at the end.
        $journals = [];
        foreach (Auth::user()->current_journals as $journal) {
            $journals[] = $journal;
        }
        foreach (Auth::user()->other_journals as $journal) {
            $journals[] = $journal;
        }
        foreach (Auth::user()->journals()->where('active', 'false')->get() as $journal) {
            $journals[] = $journal;
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
        $this->authorize('create', Journal::class);
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
        $this->authorize('create', Journal::class);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:255'
        ]);

        $journal = new Journal;
        $journal->title = $request->title;
        $journal->description = $request->description;
        $journal->current_user()->associate(Auth::id());
        $journal->creator()->associate(Auth::id());

        $journal->save();
        $journal->users()->save(Auth::user());

        return redirect()->route('journal.show', compact('journal'))
            ->with('status', "You have created a new journal called <strong>{$journal->title}</strong>. You are currently the only participant.");
    }

    /**
     * Show the page for where entries can be added to the journal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Journal $journal)
    {
        // Show the journal if the user has permission
        if (Auth::user()->can('addEntry', $journal)) {
            $drafts = $journal->entries()->where('status', 'draft')->paginate(5);
            $drafts->withPath(route('journal.show', $journal));

            return view('journal.show', compact('journal', 'drafts'));
        }

        if (Auth::user()->isInJournal($journal)) {
            if ($journal->active) {
                // Show a flash message if the user belongs to the journal and redirect.
                return redirect()->route('journal.index')
                    ->with('status', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to view it when it's your turn.");
            } else {
                // Redirect to the contents page
                return redirect()->route('journal.contents', $journal);
            }
        }

        // Otherwise throw exception
        throw new AuthorizationException;
    }

    /**
     * Show the journal settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request, Journal $journal)
    {
        if (Auth::user()->can('viewSettings', $journal)) {
            return view('journal.settings', compact('journal'));
        }

        // Show a flash message and redirect if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            return redirect()->route('journal.index')
                ->with('status', "Only {$journal->creator->name} can edit the settings for <strong>{$journal->title}</strong>.");
        }

        // Otherwise throw exception
        throw new AuthorizationException;
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
        $this->authorize('update', $journal);

        $request->validate([
            'title' => 'sometimes|required|max:255',
            'description' => 'nullable|max:255'
        ]);


        if ($request->has('title')) {
            $journal->title = $request->title;
        }

        if ($request->has('description')) {
            $journal->description = $request->description;
        }

        $status = "<strong>{$journal->title}</strong> has been updated.";

        if ($request->has('period')) {
            $journal->period = $request->period;
            // Only set the date of next change if there is more than one participant
            if ($journal->users->count() > 1) {
                $journal->next_change = now()->addSeconds($request->period);
                $formatted_next_change = new Carbon($journal->next_change, config('timezone', 'America/New_York'));
                $formatted_next_change = $formatted_next_change->format('F jS \\a\\t g:ia');
                $status = "The rotation setting for <strong>{$journal->title}</strong> has been saved. It is currently in the possession of <strong>{$journal->current_user->name}</strong> and will next rotate on <strong>{$formatted_next_change}</strong>.";
            } else {
                $journal->next_change = null;
                $status = "The rotation setting for <strong>{$journal->title}</strong> has been saved, but this journal will never actually rotate, since you are the only participant. (Is it time to invite a friend?)";
            }
        }

        $journal->save();

        return redirect()->route('journal.settings', compact('journal'))
            ->with('status', $status);
    }

    /**
     * Archive the journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function archive(Request $request, Journal $journal)
    {
        $this->authorize('archive', $journal);

        if ($journal->active) {
            // If active, then archive
            $journal->active = false;
            $journal->current_user()->dissociate();
            $journal->save();

            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been archived.");
        } else {
            // If inactive, then unarchive
            $journal->active = true;
            $journal->current_user()->associate(Auth::user());
            $journal->save();

            $request->session()->flash('status', "<strong>{$journal->title}</strong> has been unarchived and is now in your possession.");
        }
        return redirect()->route('journal.settings', $journal);
    }

    /**
     * Remove the journal from storage
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal);

        $journal->delete();
        return redirect()->route('journal.index')
            ->with('status', "<strong>{$journal->title}</strong> has been deleted.");
    }

    /**
     * Un-delete a journal
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function restore(Journal $journal)
    {
        $this->authorize('restore', $journal);

        $journal->restore();
        return redirect()->route('journal.index')
            ->with('status', "<strong>{$journal->title}</strong> has been restored from the archive.");
    }

    /**
     * Process an invitation to join a journal
     *
     * @param  \App\Http\Requests\StoreInvite  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function invite(StoreInvite $request, Journal $journal)
    {
        $this->authorize('invite', $journal);

        $request->validated();

        // Create a new invite and send it
        $invite = new Invite;
        $invite->name = $request->name;
        $invite->email = $request->email;

        // Does this user already have an account? If so, associate it.
        if ($user = User::where('email', $request->email)->first()) {
            $invite->user()->associate($user);
        }

        $invite->sender()->associate(Auth::user());
        $invite->journal()->associate($journal);
        Auth::user()->invites_sent()->save($invite);

        // Send a notification and trigger an event
        $invite->sendInviteNotification();
        event(new UserInvited($invite));

        return redirect()->route('journal.settings', compact('journal'))
            ->with('status', "An invitation to join <strong>{$journal->title}</strong> will be sent to <strong>{$invite->name}</strong> at <strong>{$invite->email}</strong>.");
    }

    /**
     * Display all the entries in a journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function contents(Request $request, Journal $journal)
    {
        if (Auth::user()->can('view', $journal)) {
            $entries = $journal->entries()->where('status', 'final')->paginate(10);
            $entries->withPath(route('journal.contents', $journal));

            return view('entry.index', compact('journal', 'entries'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            return redirect()->route('journal.index')
                ->with('warning', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to read it when it's your turn.");
        }

        // Otherwise throw exception
        throw new AuthorizationException;
    }

    /**
     * Add an entry to the journal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Journal $journal) {
        if (Auth::user()->can('addEntry', $journal)) {
            return view('entry.create', compact('journal'));
        }

        // Show a flash message if the user belongs to the journal.
        if (Auth::user()->isInJournal($journal)) {
            return redirect()->route('journal.index')
                ->with('status', "{$journal->current_user->name} has <strong>{$journal->title}</strong> right now. You'll be able to write in it when it's your turn.");
        }

        // Otherwise throw exception
        throw new AuthorizationException;
    }
}

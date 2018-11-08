<?php

namespace App\Policies;

use App\User;
use App\Journal;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function view(User $user, Journal $journal)
    {
        // Only the current user can view the journal.
        return $user->id === $journal->current_user->id;
    }

    /**
     * Determine whether the user can create journals.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // Any authorized user can create a journal
        return true;
    }

    /**
     * Determine whether the user can update the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function update(User $user, Journal $journal)
    {
        // Only the journal creator can update it.
        return $user->id === $journal->creator->id;
    }

    /**
     * Determine whether the user can invite others to join the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function invite(User $user, Journal $journal)
    {
        // Only the journal creator can invite others to join.
        return $user->id === $journal->creator->id;
    }

    /**
     * Determine whether the user can add new entries to the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function addEntry(User $user, Journal $journal)
    {
        // Only the current user can write in the journal.
        return $user->id === $journal->current_user->id;
    }

    /**
     * Determine whether the user can archive the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function archive(User $user, Journal $journal)
    {
        // Only the journal creator can archive it.
        return $user->id === $journal->creator->id;
    }

    /**
     * Determine whether the user can delete the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function delete(User $user, Journal $journal)
    {
        // Only the journal creator can delete it.
        return $user->id === $journal->creator->id;
    }

    /**
     * Determine whether the user can restore the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function restore(User $user, Journal $journal)
    {
        // Only the journal creator can restore it.
        return $user->id === $journal->creator->id;
    }

    /**
     * Determine whether the user can permanently delete the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function forceDelete(User $user, Journal $journal)
    {
        // Only the journal creator can force delete it.
        return $user->id === $journal->creator->id;
    }
}

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
        if ($journal->active) {
            // Only the current user can view active journals,
            return $user->id === $journal->current_user->id;
        }

        // But all journal participants can read archived journals.
        return $user->isInJournal($journal);
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
     * Determine whether the user can view the journal settings page.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function viewSettings(User $user, Journal $journal)
    {
        // The settings page offers options for updating, archiving,
        // and inviting other users.

        return ($user->can('update', $journal) ||
                $user->can('invite', $journal) ||
                $user->can('archive', $journal)
        );
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
        // Only the journal creator with a verified email address can invite others to join.
        // Only active journals can accept new participants
        return ($journal->active &&
                $user->hasVerifiedEmail() &&
                $user->id === $journal->creator->id);
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
        // Only the current user can write in the journal,
        // and only if the journal is active.
        return ($journal->active &&
                $user->id === $journal->current_user->id);
    }

    /**
     * Determine whether the user can archive (or unarchive) the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function archive(User $user, Journal $journal)
    {
        // Only the journal creator can archive (or unarchive) it.
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
}

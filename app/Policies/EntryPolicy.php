<?php

namespace App\Policies;

use App\User;
use App\Entry;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the entry.
     *
     * @param  \App\User  $user
     * @param  \App\Entry  $entry
     * @return mixed
     */
    public function view(User $user, Entry $entry)
    {
        if ($entry->journal->active) {
            // In an active journal, only the current user of the journal can view an entry
            return $user->id === $entry->journal->current_user->id;
        } else {
            // In an archived journal, all journal users can read it
            return ($user->isInJournal($entry->journal));
        }
    }

    /**
     * Determine whether the user can update the entry.
     *
     * @param  \App\User  $user
     * @param  \App\Entry  $entry
     * @return mixed
     */
    public function update(User $user, Entry $entry)
    {
        // Only the current user of the journal can edit entries,
        // and only draft entries may be edited.
        return ($user->id === $entry->journal->current_user->id && $entry->status == 'draft');
    }

    /**
     * Determine whether the user can delete the entry.
     *
     * @param  \App\User  $user
     * @param  \App\Entry  $entry
     * @return mixed
     */
    public function delete(User $user, Entry $entry)
    {
        // Only the current user of the journal can delete entries,
        // and only draft entries may be deleted.
        return ($user->id === $entry->journal->current_user->id && $entry->status == 'draft');
    }

    /**
     * Determine whether the user can restore the entry.
     *
     * @param  \App\User  $user
     * @param  \App\Entry  $entry
     * @return mixed
     */
    public function restore(User $user, Entry $entry)
    {
        // Only the current user of the journal can restore entries.
        return $user->id === $entry->journal->current_user->id;
    }

    /**
     * Determine whether the user can permanently delete the entry.
     *
     * @param  \App\User  $user
     * @param  \App\Entry  $entry
     * @return mixed
     */
    public function forceDelete(User $user, Entry $entry)
    {
        // Only the current user of the journal can force delete entries.
        return $user->id === $entry->journal->current_user->id;
    }
}

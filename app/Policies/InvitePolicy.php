<?php

namespace App\Policies;

use App\User;
use App\Invite;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view (and accept/decline) the invite.
     *
     * @param  \App\User  $user
     * @param  \App\Invite  $invite
     * @return mixed
     */
    public function view(User $user, Invite $invite)
    {
        // Only the user who received the invite can view it.
        // The user must already have created an account.
        return ($user->id === $invite->user_id);
    }

    /**
     * Determine whether the user can resend the invite.
     *
     * @param  \App\User  $user
     * @param  \App\Invite  $invite
     * @return mixed
     */
    public function resend(User $user, Invite $invite)
    {
        // Only resend invites that haven't been accepted.
        // Only the user who originally sent the invite can resend it.
        return (!$invite->accepted_at &&
                $user->id === $invite->sender_id);
    }

    /**
     * Determine whether the user can delete the invite.
     *
     * @param  \App\User  $user
     * @param  \App\Invite  $invite
     * @return mixed
     */
    public function delete(User $user, Invite $invite)
    {
        // Only delete invites that haven't been accepted.
        // Only the user who originally sent the invite can resend it.
        return (!$invite->accepted_at &&
                $user->id === $invite->sender_id);
    }
}

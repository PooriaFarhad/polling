<?php

namespace App\Policies;

use App\User;
use App\PollOption;
use Illuminate\Auth\Access\HandlesAuthorization;

class PollOptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the poll option.
     *
     * @param  \App\User  $user
     * @param  \App\PollOption  $pollOption
     * @return mixed
     */
    public function view(User $user, PollOption $pollOption)
    {
        //
    }

    /**
     * Determine whether the user can create poll options.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $poll)
    {
        return $user->id == $poll->user_id;
    }

    /**
     * Determine whether the user can update the poll option.
     *
     * @param  \App\User  $user
     * @param  \App\PollOption  $pollOption
     * @return mixed
     */
    public function update(User $user, PollOption $pollOption)
    {
        return $user->id == $pollOption->poll->user_id;
    }

    /**
     * Determine whether the user can delete the poll option.
     *
     * @param  \App\User  $user
     * @param  \App\PollOption  $pollOption
     * @return mixed
     */
    public function delete(User $user, PollOption $pollOption)
    {
        return $user->id == $pollOption->poll->user_id;
    }

    /**
     * Determine whether the user can restore the poll option.
     *
     * @param  \App\User  $user
     * @param  \App\PollOption  $pollOption
     * @return mixed
     */
    public function restore(User $user, PollOption $pollOption)
    {
        return $user->id == $pollOption->poll->user_id;
    }

    /**
     * Determine whether the user can permanently delete the poll option.
     *
     * @param  \App\User  $user
     * @param  \App\PollOption  $pollOption
     * @return mixed
     */
    public function forceDelete(User $user, PollOption $pollOption)
    {
        return $user->id == $pollOption->poll->user_id;
    }
}

<?php

namespace App\Policies;

use App\Models\Reaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reactions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the reaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reaction  $reaction
     * @return mixed
     */
    public function view(User $user, Reaction $reaction)
    {
        //
    }

    /**
     * Determine whether the user can create reactions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the reaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reaction  $reaction
     * @return mixed
     */
    public function update(User $user, Reaction $reaction)
    {
        return $reaction->from_user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the reaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reaction  $reaction
     * @return mixed
     */
    public function delete(User $user, Reaction $reaction)
    {
        return $reaction->from_user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the reaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reaction  $reaction
     * @return mixed
     */
    public function restore(User $user, Reaction $reaction)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the reaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reaction  $reaction
     * @return mixed
     */
    public function forceDelete(User $user, Reaction $reaction)
    {
        //
    }
}

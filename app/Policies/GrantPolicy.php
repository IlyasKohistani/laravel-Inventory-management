<?php

namespace App\Policies;

use App\Models\Grant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GrantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Grant $grant)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Grant $grant)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Grant $grant)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Grant $grant)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Grant $grant)
    {
        //
    }

    
    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @return void|bool
     */
    public function before(User $user)
    {
        return !empty(array_intersect(['owner','editor'], $user->user_roles));
    }
}

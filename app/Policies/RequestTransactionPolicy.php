<?php

namespace App\Policies;

use App\Models\RequestTransaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestTransactionPolicy
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
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, RequestTransaction $requestTransaction)
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
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, RequestTransaction $requestTransaction)
    {
    }

    /**
     * Determine whether the user can update the status of model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateStatus(User $user, RequestTransaction $requestTransaction)
    {
        return in_array('approval', $user->user_roles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, RequestTransaction $requestTransaction)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, RequestTransaction $requestTransaction)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RequestTransaction  $requestTransaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, RequestTransaction $requestTransaction)
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
        if (!empty(array_intersect(['owner', 'editor'], $user->user_roles)))
            return true;
    }
}

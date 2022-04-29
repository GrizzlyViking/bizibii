<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionsPolicy
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
        return true;
        // return $user->is(request()->user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction $transactions
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Transaction $transactions)
    {
        return $user->is(request()->user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transactions
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Transaction $transactions)
    {
        return $transactions->bankAccount->user->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \App\Models\Transaction  $transactions
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Transaction $transactions)
    {
        return $transactions->bankAccount->user->is($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param \App\Models\Transaction  $transactions
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Transaction $transactions)
    {
        return $transactions->bankAccount->user->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \App\Models\Transaction  $transactions
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Transaction $transactions)
    {
        return $transactions->bankAccount->user->is($user);
    }
}

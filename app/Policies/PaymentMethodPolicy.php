<?php

namespace App\Policies;

use App\PaymentMethod;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentMethodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any accounts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the account.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentMethod  $payment_method
     * @return mixed
     */
    public function view(User $user, PaymentMethod $payment_method)
    {
        return $user->id === $payment_method->user_id;
    }

    /**
     * Determine whether the user can create accounts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the account.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentMethod  $payment_method
     * @return mixed
     */
    public function update(User $user, PaymentMethod $payment_method)
    {
        return $user->id === $payment_method->user_id;
    }

    /**
     * Determine whether the user can delete the account.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentMethod  $payment_method
     * @return mixed
     */
    public function delete(User $user, PaymentMethod $payment_method)
    {
        return $user->id === $payment_method->user_id;
    }

    /**
     * Determine whether the user can restore the account.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentMethod  $payment_method
     * @return mixed
     */
    public function restore(User $user, PaymentMethod $payment_method)
    {
        return $user->id === $payment_method->user_id;
    }

    /**
     * Determine whether the user can permanently delete the account.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentMethod  $payment_method
     * @return mixed
     */
    public function forceDelete(User $user, PaymentMethod $payment_method)
    {
        return $user->id === $payment_method->user_id;
    }
}

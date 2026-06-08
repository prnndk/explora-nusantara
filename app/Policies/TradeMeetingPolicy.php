<?php

namespace App\Policies;

use App\Models\TradeMeeting;
use App\Models\User;

class TradeMeetingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isSeller() || $user->isBuyer();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TradeMeeting $tradeMeeting): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isSeller()) {
            return $user->seller && $tradeMeeting->seller_id === $user->seller->id;
        }

        if ($user->isBuyer()) {
            return $user->buyer && $tradeMeeting->buyer_id === $user->buyer->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSeller();
    }

    /**
     * Determine whether the user can update the model.
     *
     * Only admins approve/reject trade meetings (see App\Livewire\TradeMeeting\Admin).
     */
    public function update(User $user, TradeMeeting $tradeMeeting): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TradeMeeting $tradeMeeting): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TradeMeeting $tradeMeeting): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TradeMeeting $tradeMeeting): bool
    {
        return $user->isAdmin();
    }
}

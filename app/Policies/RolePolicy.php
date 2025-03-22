<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->canDoCriticalAction()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        if ($user->canBeAGod()) {
            return true;
        } elseif ($user->canDoCriticalAction() && $user->strongRole()->level > $role->level) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        if ($user->canBeAGod()) {
            return true;
        } elseif ($user->canDoCriticalAction() && $user->strongRole()->level > $role->level) {
            return true;
        } else {
            return false;
        }
    }
}

<?php

namespace App\Policies;

use App\Models\User;

class FacultyPolicy
{
    /**
     * Can join to any faculty
     */
    public function join(User $user): bool
    {
        if (!$user || !$user->hasVerifiedEmail()) return false;
        if ($user->faculty_id !== null) return false;
        if (! $user->isStudent()) return false;

        return true;
    }
}

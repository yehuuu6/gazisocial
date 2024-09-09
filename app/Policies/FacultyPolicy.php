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
        // Check if the user is a student
        return $user->isStudent();
    }
}

<?php

namespace App\Policies;

use App\Models\PollVote;
use App\Models\User;

class PollVotePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // If the user is not logged in, return false
        if (!$user) {
            return false;
        }

        // If the user is not verified, return false
        if (!$user->hasVerifiedEmail()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PollVote $vote): bool
    {
        if (!$user) {
            return false;
        }
        return $user->id === $vote->user_id;
    }
}

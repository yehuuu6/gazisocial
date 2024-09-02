<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
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
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Comment $comment): bool
    {
        return $user->id === $comment->user->id;
    }
}

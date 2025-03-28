<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
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

        if ($user->is_banned) {
            return false;
        }

        return true;
    }

    public function update(User $user, Comment $comment): bool
    {
        if ($user->canDoHighLevelAction() && $user->strongRole()->level > $comment->user->strongRole()->level) {
            return true;
        }

        if ($user->is_banned) {
            return false;
        }

        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // If the user has role admin or gazisocial, return true
        if ($user->canDoHighLevelAction() && $user->strongRole()->level > $comment->user->strongRole()->level) {
            return true;
        }

        return $user->id === $comment->user_id;
    }

    public function report(User $user, Comment $comment): bool
    {
        // If the user is not verified, return false
        if (!$user->hasVerifiedEmail()) {
            return false;
        }

        return true;
    }
}

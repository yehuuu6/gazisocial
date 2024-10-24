<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
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
    public function update(User $user, Post $post): bool
    {

        // if user has admin role, return true
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $post->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user->id;
    }
}

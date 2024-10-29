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
     * Determine if the given post can be updated by the user.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post): bool
    {
        // Check if the user is the owner of the post
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}

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

        if ($user->canDoLowLevelAction()) {
            return true;
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
        // If the user can do high level actions
        // And the users role level is higher than or equal to the post owner's role level
        // Then the user can edit the post
        if ($user->canDoHighLevelAction() && $user->strongRole()->level >= $post->user->strongRole()->level) {
            return true;
        }

        // Kullanıcı postun sahibi ise düzenleyebilir
        return $user->id === $post->user_id;
    }

    public function report(User $user): bool
    {
        // If the user is not logged in, return false
        if (!$user) {
            return false;
        }

        // If the user is not verified, return false
        if (!$user->hasVerifiedEmail()) {
            return false;
        }

        if ($user->canDoLowLevelAction()) {
            return true;
        }

        return true;
    }

    public function publish(User $user): bool
    {
        if ($user->canDoHighLevelAction()) {
            return true;
        }

        return false;
    }

    public function pin(User $user): bool
    {
        if ($user->canDoCriticalAction()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // If the user can do critical actions
        // And the users role level is higher than the post owner's role level
        // Then the user can delete the post
        if ($user->canDoCriticalAction() && $user->strongRole()->level > $post->user->strongRole()->level) {
            return true;
        }

        return $user->id === $post->user_id;
    }
}

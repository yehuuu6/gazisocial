<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class LikePolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Model $likeable): bool
    {

        // If the user is not verified, return false
        if (!$user->hasVerifiedEmail()) {
            return false;
        }

        if (! in_array($likeable::class, [Post::class, Comment::class, Reply::class])) {
            return false;
        }

        return $likeable->likes()->whereBelongsTo($user)->doesntExist();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $likeable): bool
    {
        if (! in_array($likeable::class, [Post::class, Comment::class, Reply::class])) {
            return false;
        }

        return $likeable->likes()->whereBelongsTo($user)->exists();
    }
}

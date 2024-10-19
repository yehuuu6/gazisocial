<?php

namespace App\Observers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     */
    public function created(Like $like): void
    {

        // Update the last_activity of the user
        $like->user->update(['last_activity' => now()]);

        // Increment the likes_count on the likeable
        if (! in_array($like->likeable::class, [Post::class, Comment::class, Reply::class])) return;

        $like->likeable->increment('likes_count');

        // Increment the popularity of the likeable model if it is a Post
        if ($like->likeable instanceof Post) {
            $like->likeable->increment('popularity', $like->popularityValue());
        }
    }

    /**
     * Handle the Like "updated" event.
     */
    public function updated(Like $like): void
    {
        //
    }

    /**
     * Handle the Like "deleted" event.
     */
    public function deleted(Like $like): void
    {

        // Update the last_activity of the user
        $like->user->update(['last_activity' => now()]);

        // Decrement the likes_count on the likeable
        if (! in_array($like->likeable::class, [Post::class, Comment::class, Reply::class])) return;

        $like->likeable->decrement('likes_count');

        // Decrement the popularity of the likeable model if it is a Post
        if ($like->likeable instanceof Post) {
            $like->likeable->decrement('popularity', $like->popularityValue());
        }
    }
}

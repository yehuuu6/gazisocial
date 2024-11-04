<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        if ($post->is_anon) return;

        // Update the last_activity of the user
        $post->user->update(['last_activity' => now()]);

        $post->user->increment('posts_count');
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleting" event.
     */
    public function deleting(Post $post): void
    {
        // Delete the likes of the post
        $post->likes()->delete();

        // Update the last_activity of the user
        $post->user->update(['last_activity' => now()]);

        $post->user->decrement('posts_count');
        $post->user->decrement('comments_count', $post->comments_count);
        $post->user->decrement('replies_count', $post->replies_count);
    }
}

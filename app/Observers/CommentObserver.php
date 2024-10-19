<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        // Increment the comments_count on the post and user
        $comment->post->increment('comments_count');
        $comment->user->increment('comments_count');

        // Update the last_activity of the user
        $comment->user->update(['last_activity' => now()]);

        // Increment the popularity of the likeable model if it is a Post
        $comment->post->increment('popularity', $comment->popularityValue());
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "deleting" event.
     */
    public function deleting(Comment $comment): void
    {
        // Delete the likes of the comment
        $comment->likes()->delete();
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        //$comment->load('post', 'user');
        // Decrement the comments_count on the post and user
        $comment->post->decrement('comments_count');
        $comment->user->decrement('comments_count');

        // Update the last_activity of the user
        $comment->user->update(['last_activity' => now()]);

        // Decrement the popularity of the likeable model if it is a Post
        $comment->post->decrement('popularity', $comment->popularityValue());
    }
}

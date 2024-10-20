<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Reply;

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
        $comment->post->increment('popularity', Comment::popularityValue());
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
        // Get the count of replies before they are deleted
        $repliesCount = $comment->replies_count;

        // Decrement the replies_count on the post and user
        $comment->post->decrement('replies_count', $repliesCount);
        $comment->user->decrement('replies_count', $repliesCount);

        // Delete the likes of the comment
        $comment->likes()->delete();
    }
    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        // Decrement the comments_count on the post and user
        $comment->post->decrement('comments_count');
        $comment->user->decrement('comments_count');

        // Update the last_activity of the user
        $comment->user->update(['last_activity' => now()]);

        $popularityValue = Comment::popularityValue() + ($comment->replies_count * Reply::popularityValue());

        // Decrement the popularity of the likeable model if it is a Post
        $comment->post->decrement('popularity', $popularityValue);
    }
}

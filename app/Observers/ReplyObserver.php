<?php

namespace App\Observers;

use App\Models\Reply;

class ReplyObserver
{
    /**
     * Handle the Reply "created" event.
     */
    public function created(Reply $reply): void
    {
        $reply->comment->increment('replies_count');
        $reply->user->increment('replies_count');
        $reply->comment->post->increment('replies_count');

        // Update the last_activity of the user
        $reply->user->update(['last_activity' => now()]);

        // Increment the popularity of the likeable model if it is a Post
        $reply->comment->post->increment('popularity', Reply::popularityValue());

        // Increment the popularity of the likeable model if it is a Comment
        $reply->comment->increment('popularity', Reply::popularityValue());
    }

    /**
     * Handle the Reply "updated" event.
     */
    public function updated(Reply $reply): void
    {
        //
    }

    /**
     * Handle the Reply "deleting" event.
     */
    public function deleting(Reply $reply): void
    {
        // Decrement the replies_count on the comment, post, and user before cascading deletions
        $reply->comment->decrement('replies_count');
        $reply->user->decrement('replies_count');
        $reply->comment->post->decrement('replies_count');

        // Delete the likes of the reply
        $reply->likes()->delete();
    }

    /**
     * Handle the Reply "deleted" event.
     */
    public function deleted(Reply $reply): void
    {

        // Update the last_activity of the user
        $reply->user->update(['last_activity' => now()]);

        // Decrement the popularity of the likeable model if it is a Post
        $reply->comment->post->decrement('popularity', Reply::popularityValue());

        // Decrement the popularity of the likeable model if it is a Comment
        $reply->comment->decrement('popularity', Reply::popularityValue());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    protected static function booted()
    {
        static::created(function ($comment) {
            $comment->load('user', 'post');
            $comment->user->update(['last_activity' => now()]);
            $comment->user->increment('comments_count');
            $comment->post->increment('comments_count');

            // Increment the popularity of the post
            $comment->post->increment('popularity', $comment->popularityValue());
        });

        static::deleted(function ($comment) {
            $comment->load('user', 'post');
            $comment->user->update(['last_activity' => now()]);
            $comment->user->decrement('comments_count');
            $comment->post->decrement('comments_count');

            // Decrement the popularity of the post
            $comment->post->decrement('popularity', $comment->popularityValue());
        });

        static::deleting(function ($comment) {
            // Decrement counts for replies before they are deleted
            foreach ($comment->replies as $reply) {
                $reply->load('user', 'comment.post');
                $reply->user->decrement('replies_count');
                $reply->comment->post->decrement('replies_count');
                $reply->comment->decrement('replies_count');
                $reply->comment->post->decrement('popularity', $reply->popularityValue());

                // Delete likes attached to the reply
                $reply->likes()->delete();
            }

            // Delete likes attached to the comment
            $comment->likes()->delete();
        });
    }

    public function popularityValue()
    {
        return 2;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

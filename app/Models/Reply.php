<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'comment_id', 'content'];

    protected static function booted()
    {
        static::created(function ($reply) {

            $reply->load('user', 'post', 'comment');

            $reply->user->update(['last_activity' => now()]);
            $reply->user->increment('replies_count');
            $reply->comment->post->increment('replies_count');
            $reply->comment->increment('replies_count');

            // Increment the popularity of the post
            $reply->comment->post->increment('popularity', $reply->popularityValue());
        });
    }

    public function popularityValue()
    {
        return 1;
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}

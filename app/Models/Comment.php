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

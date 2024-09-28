<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];

    protected static function booted()
    {
        static::created(function ($like) {
            $like->user->update(['last_activity' => now()]);

            if (! in_array($like->likeable::class, [Post::class, Comment::class, Reply::class])) return;

            $like->likeable->increment('likes_count');

            // Increment the popularity of the likeable model if it is a Post
            if ($like->likeable instanceof Post) {
                $like->likeable->increment('popularity', $like->popularityValue());
            }
        });
    }

    public function popularityValue()
    {
        return 3;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likeable()
    {
        return $this->morphTo();
    }
}

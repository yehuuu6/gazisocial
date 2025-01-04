<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($comment) {
            $comment->replies()->each(function ($reply) {
                $reply->delete();
            });
        });
    }

    public function isNew()
    {
        // Return true if the comment is authored by the authenticated user and created in the last 10 seconds.
        return Auth::check() && $this->user_id === Auth::id() && $this->created_at >= now()->subSeconds(10);
    }

    public function loadReplies(int $limit = 3)
    {
        $newReply = null;

        if (Auth::check()) {
            // Check if the comment has a new reply created in the last 10 seconds.
            $newReply = $this->replies()
                ->where('user_id', Auth::id())
                ->where('created_at', '>=', now()->subSeconds(10))
                ->orderBy('created_at', 'desc')
                ->first();
        }

        // If the authenticated user has a new reply, we will put it at the beginning of the replies list.
        if ($newReply) {
            $replies = $this->replies()
                ->with('user')
                ->withCount('replies')
                ->where('id', '!=', $newReply->id)
                ->orderBy('created_at', 'asc')
                ->limit($limit - 1)
                ->get();

            return $replies->prepend($newReply);
        } else {
            return $this->replies()
                ->with('user')
                ->withCount('replies')
                ->orderBy('created_at', 'asc')
                ->limit($limit)
                ->get();
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function replies(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Return the popularity value of the model.
     * @return int
     */
    public static function popularityValue()
    {
        return 2;
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}

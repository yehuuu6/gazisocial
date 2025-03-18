<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
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

    protected $with = [
        'post'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            // Update user's last activity
            $comment->user->heartbeat();
            // Update the post's popularity
            $comment->post->incrementPopularity($comment->popularityValue());
        });

        static::deleted(function ($comment) {
            $comment->post->decrementPopularity($comment->popularityValue());
        });

        static::deleting(function ($comment) {
            $comment->replies()->each(function ($reply) {
                $reply->delete();
            });
        });
    }

    /**
     * Get the comments's single thread route.
     * @param array $parameters
     * @return string
     */
    public function showRoute(array $parameters = [])
    {
        return route('posts.show.comment', [$this->post_id, Str::slug($this->post->title), $this, ...$parameters]);
    }

    public function toggleLike()
    {
        DB::transaction(function () {
            if ($this->isLiked()) {
                $like = $this->likes()->where('user_id', Auth::id())->first();
                if ($like) {
                    $like->removeLike();
                    $like->delete();
                }
            } else {
                $like = $this->likes()->create([
                    'user_id' => Auth::id()
                ]);
                $like->addLike();
            }
        });

        // Update user's last activity
        $this->user->heartbeat();
    }

    public function loadReplies(int $limit = 3, ?int $renderedReplyId = null)
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
                ->where('id', '!=', $newReply->id);

            if ($renderedReplyId !== null) {
                $replies->where('id', '=', $renderedReplyId);
            }

            $replies = $replies->orderBy('created_at', 'asc')
                ->limit($limit - 1)
                ->get();

            return $replies->prepend($newReply);
        } else {
            $replies = $this->replies()
                ->with('user')
                ->withCount('replies');

            if ($renderedReplyId !== null) {
                $replies->where('id', '=', $renderedReplyId);
            }

            $replies = $replies->orderBy('created_at', 'asc')
                ->limit($limit)
                ->get();

            return $replies;
        }
    }

    public function isLiked(): bool
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAllRepliesCount(): int
    {
        return $this->hasMany(Comment::class, 'parent_id')->count();
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
        return 1;
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}

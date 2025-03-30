<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\ConvertsMarkdownToHtml;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory, ConvertsMarkdownToHtml, Searchable;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'image_urls' => 'array',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Keep only essential fields for search indexing
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => Str::limit($this->content, 500), // Limit body size
            'created_at' => $this->created_at->timestamp,
        ];
    }

    protected static function booted()
    {
        // Delete polls from the database when a post is deleted
        static::deleting(function ($post) {
            foreach ($post->polls as $poll) {
                $poll->delete();
            }
        });

        static::addGlobalScope(function ($builder) {
            // Check for authenticated user at query time, not boot time
            if (!Auth::check()) {
                // Guests can only see published posts
                $builder->where('is_published', true);
                return;
            }

            /**
             * @var \App\Models\User $user
             */
            $user = Auth::user();

            if ($user->canDoHighLevelAction()) {
                // Users with high level permissions can see all posts
                return;
            }

            // Authors can see their own posts (both published and unpublished)
            // Others can only see published posts
            $builder->where(function ($query) use ($user) {
                $query->where('is_published', true)
                    ->orWhere('user_id', $user->id);
            });
        });
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
    }

    public function report()
    {
        $this->update(['is_reported' => true]);
    }

    public function incrementPopularity(int $amount)
    {
        $this->increment('popularity', $amount);
    }

    public function decrementPopularity(int $amount)
    {
        $this->decrement('popularity', $amount);
    }

    public function isLiked(): bool
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    /**
     * Will return the default page logo if no image is set.
     */
    public function getFirstImageUrl(): string
    {
        return $this->image_urls[0] ?? asset('logos/GS_LOGO_DEFAULT.png');
    }

    public function getCommentsCount(): int
    {
        return $this->hasMany(Comment::class)->count();
    }

    public function isAnonim(): bool
    {
        return $this->is_anonim;
    }

    public function getDisplayName(): string
    {
        if ($this->isAnonim()) {
            return 'Anonim';
        }

        return $this->user->name;
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function polls(): BelongsToMany
    {
        return $this->belongsToMany(Poll::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function title(): Attribute
    {
        return Attribute::set(fn($value) => Str::title($value));
    }

    /**
     * Get the post's route.
     * @param array $parameters
     * @return string
     */
    public function showRoute(array $parameters = [])
    {
        return route('posts.show', [$this, Str::slug($this->title), ...$parameters]);
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return $this->is_published;
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        'id',
    ];

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
}

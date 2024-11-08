<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\ConvertsMarkdownToHtml;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, ConvertsMarkdownToHtml;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'html',
        'is_anon',
    ];

    /**
     * Check if the post is anonymous but belongs to the authenticated user.
     * @return bool
     */
    public function anonToMe()
    {
        return $this->is_anon && $this->user_id === Auth::id();
    }

    /**
     * Return the total number of comments and replies.
     * @return string 
     */
    public function getCommentsCount()
    {
        return $this->comments_count + $this->replies_count;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function polls(): HasMany
    {
        return $this->hasMany(Poll::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
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

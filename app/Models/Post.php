<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\ConvertsMarkdownToHtml;

class Post extends Model
{
    use HasFactory, ConvertsMarkdownToHtml;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'html',
    ];

    protected static function booted()
    {
        // Create activity model when a post is created
        static::created(function ($post) {
            Activity::create([
                'user_id' => $post->user_id,
                'post_id' => $post->id,
                'content' => 'Yeni bir konu oluşturdu!',
                'link' => $post->showRoute(),
            ]);
        });
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function polls()
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

    public function showRoute(array $parameters = [])
    {
        return route('post.show', [$this, Str::slug($this->title), ...$parameters]);
    }
}

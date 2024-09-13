<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
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

    public function html(): Attribute
    {
        return Attribute::get(fn() => str($this->content)->markdown());
    }
}

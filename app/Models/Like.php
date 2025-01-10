<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function addLike()
    {
        $this->increaseLikeCount();
        $this->increasePopularity();

        // Update user's last activity
        $this->user->heartbeat();
    }

    public function removeLike()
    {
        $this->decreaseLikeCount();
        $this->decreasePopularity();

        // Update user's last activity
        $this->user->heartbeat();
    }

    // Increase the popularity of the likeable.
    private function increasePopularity()
    {
        $this->likeable->increment('popularity', static::popularityValue());
    }

    // Decrease the popularity of the likeable.
    private function decreasePopularity()
    {
        $this->likeable->decrement('popularity', static::popularityValue());
    }

    // Increase the likes count of the likeable.
    private function increaseLikeCount()
    {
        $this->likeable->increment('likes_count');
    }

    // Decrease the likes count of the likeable.
    private function decreaseLikeCount()
    {
        $this->likeable->decrement('likes_count');
    }

    /**
     * Return the popularity value of the model.
     * @return int
     */
    public static function popularityValue()
    {
        return 2;
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

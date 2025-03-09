<?php

namespace App\Models\ZalimKasaba;

use App\Enums\ZalimKasaba\PlayerRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameRole extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'enum' => PlayerRole::class,
    ];

    public function lobbies(): BelongsToMany
    {
        return $this->belongsToMany(Lobby::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}

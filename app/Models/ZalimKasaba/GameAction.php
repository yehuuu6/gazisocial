<?php

namespace App\Models\ZalimKasaba;

use App\Enums\ZalimKasaba\ActionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameAction extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'action_type' => ActionType::class,
    ];

    public function lobby(): BelongsTo
    {
        return $this->belongsTo(Lobby::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'actor_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'target_id');
    }
}

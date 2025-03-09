<?php

namespace App\Models\ZalimKasaba;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LynchVote extends Model
{
    protected $guarded = ['id'];

    public function lobby(): BelongsTo
    {
        return $this->belongsTo(Lobby::class);
    }

    public function voter(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'voter_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'target_id');
    }
}

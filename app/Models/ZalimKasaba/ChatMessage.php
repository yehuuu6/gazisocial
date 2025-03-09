<?php

namespace App\Models\ZalimKasaba;

use App\Enums\ZalimKasaba\ChatMessageFaction;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'type' => ChatMessageType::class,
        'faction' => ChatMessageFaction::class,
    ];

    protected $with = ['user'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (ChatMessage $message) {
            // Set the day_count to the current day count of the lobby
            $message->day_count = $message->lobby->day_count;
        });
    }

    public function lobby(): BelongsTo
    {
        return $this->belongsTo(Lobby::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

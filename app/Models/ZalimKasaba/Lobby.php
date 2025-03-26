<?php

namespace App\Models\ZalimKasaba;

use App\Models\User;
use Illuminate\Support\Str;
use App\Enums\ZalimKasaba\GameState;
use App\Models\ZalimKasaba\FinalVote;
use App\Enums\ZalimKasaba\LobbyStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lobby extends Model
{
    /** @use HasFactory<\Database\Factories\LobbyFactory> */
    use HasFactory;

    protected $guarded = ['id', 'uuid'];

    // Create an uuid on creating a new lobby
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    protected $casts = [
        'status' => LobbyStatus::class,
        'state' => GameState::class,
        'countdown_start' => 'datetime',
        'countdown_end' => 'datetime',
        'is_listed' => 'boolean',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(GameRole::class);
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function guilts(): HasMany
    {
        return $this->hasMany(GuiltThoughts::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(LynchVote::class);
    }

    public function finalVotes(): HasMany
    {
        return $this->hasMany(FinalVote::class);
    }

    public function accused(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'accused_id');
    }

    public function actions(): HasMany
    {
        return $this->hasMany(GameAction::class);
    }
}

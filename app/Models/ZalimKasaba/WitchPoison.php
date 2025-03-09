<?php

namespace App\Models\ZalimKasaba;

use Illuminate\Database\Eloquent\Model;

class WitchPoison extends Model
{
    protected $guarded = [];

    protected $with = ['target', 'poisoner'];

    public function lobby()
    {
        return $this->belongsTo(Lobby::class);
    }

    public function target()
    {
        return $this->belongsTo(Player::class, 'target_id');
    }

    public function poisoner()
    {
        return $this->belongsTo(Player::class, 'poisoner_id');
    }
}

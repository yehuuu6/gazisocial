<?php

namespace App\Models\ZalimKasaba;

use Illuminate\Database\Eloquent\Model;

class GuiltThoughts extends Model
{
    protected $guarded = ['id'];

    public function lobby()
    {
        return $this->belongsTo(Lobby::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

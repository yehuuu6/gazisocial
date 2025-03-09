<?php

namespace App\Models\ZalimKasaba;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ZalimKasaba\FinalVoteType;

class FinalVote extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'type' => FinalVoteType::class
    ];
}

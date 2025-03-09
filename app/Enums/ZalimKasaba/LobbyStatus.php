<?php

namespace App\Enums\ZalimKasaba;

enum LobbyStatus: string
{
    case ACTIVE = 'active';
    case WAITING_HOST = 'waiting_host';
    case CLOSED = 'closed';
}

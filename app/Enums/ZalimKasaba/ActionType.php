<?php

namespace App\Enums\ZalimKasaba;

enum ActionType: string
{
    case ORDER = 'order';
    case KILL = 'kill';
    case HEAL = 'heal';
    case WATCH = 'watch';
    case POISON = 'poison';
    case SHOOT = 'shoot';
    case REVEAL = 'reveal';
    case CLEAN = 'clean';
    case HAUNT = 'haunt';
    case INTERROGATE = 'interrogate';
}

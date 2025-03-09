<?php

namespace App\Enums\ZalimKasaba;

enum GameState: string
{
    case LOBBY = 'lobby';
    case PREPARATION = 'preparation';
    case DAY = 'day';
    case VOTING = 'voting';
    case DEFENSE = 'defense';
    case JUDGMENT = 'judgment';
    case LAST_WORDS = 'last_words';
    case NIGHT = 'night';
    case REVEAL = 'reveal';
    case GAME_OVER = 'game_over';

    public function isFinal(): bool
    {
        return $this === self::GAME_OVER;
    }

    public function next(): GameState
    {
        return match ($this) {
            self::LOBBY => self::PREPARATION,
            self::PREPARATION => self::DAY,
            self::DAY => self::VOTING,
            self::VOTING => self::DEFENSE,
            self::DEFENSE => self::JUDGMENT,
            self::JUDGMENT => self::LAST_WORDS,
            self::LAST_WORDS => self::NIGHT,
            self::NIGHT => self::REVEAL,
            self::REVEAL => self::DAY,
            default => self::GAME_OVER,
        };
    }
}

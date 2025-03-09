<?php

namespace App\Enums\ZalimKasaba;

enum ChatMessageType: string
{
    case DEFAULT = 'default';
    case WARNING = 'warning';
    case SUCCESS = 'success';
}

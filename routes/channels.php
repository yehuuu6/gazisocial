<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('zalim-kasaba-lobby.{lobbyId}', function (User $user, $lobbyId) {
    return $user->only('id', 'username');
});

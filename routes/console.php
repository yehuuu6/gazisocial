<?php

use App\Models\Comment;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('lobbies:cleanup')->everyFiveMinutes();

// Schedule a closure to run daily
Schedule::call(function () {
    // Grab all the comments marked as is_dangerous
    $dangerousComments = Comment::with('user')->where('is_dangerous', true)
        ->get();

    if ($dangerousComments->isEmpty()) {
        return;
    }

    // Make them all not dangerous, if user is eligible
    foreach ($dangerousComments as $comment) {
        if ($comment->user->canPublishAPost()) {
            $comment->update([
                'is_dangerous' => false,
            ]);
        }
    }
})->daily();

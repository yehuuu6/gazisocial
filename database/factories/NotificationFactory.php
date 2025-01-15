<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        $types = ['friend_request', 'comment_reply', 'post_comment', 'friend_accept'];
        $type = $this->faker->randomElement($types);

        $sender = User::inRandomOrder()->first();

        $data = match ($type) {
            'friend_request' => [
                'sender_id' => $sender->id,
                'text' => "{$sender->name} size bir arkadaşlık isteği gönderdi"
            ],
            'friend_accept' => [
                'sender_id' => $sender->id,
                'text' => "{$sender->name} arkadaşlık isteğinizi kabul etti"
            ],
            'post_comment' => [
                'sender_id' => $sender->id,
                'post_id' => rand(1, 30), // Assuming you have posts
                'comment_id' => rand(1, 100), // Assuming you have comments
                'text' => "{$sender->name} gönderinize yorum yaptı"
            ],
            'comment_reply' => [
                'sender_id' => $sender->id,
                'comment_id' => rand(1, 100), // Assuming you have comments
                'reply_id' => rand(1, 100), // Assuming you have replies
                'post_id' => rand(1, 30), // Assuming you have posts
                'text' => "{$sender->name} yorumunuza yanıt verdi"
            ]
        };

        return [
            'user_id' => 11,
            'type' => $type,
            'data' => $data,
            'read' => $this->faker->boolean(),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reply>
 */
class ReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' => User::factory(),
            'comment_id' => Comment::factory(),
            'content' => $this->faker->realText($this->faker->numberBetween(100, 750)),
            'likes_count' => 0,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

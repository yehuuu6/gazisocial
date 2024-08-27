<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = str(fake()->sentence)->beforeLast('.')->title();
        $slug = Str::slug($title);
        return [
            'user_id' => User::factory(),
            'title' => $title,
            'content' => $this->faker->realText($this->faker->numberBetween(100, 3000)),
            'slug' => $slug,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
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
            'likeable_id' => Post::factory(),
            'likeable_type' => $this->likeableType(...),
        ];
    }

    public function likeableType(array $values)
    {
        $type = $values['likeable_id'];
        $modelName = $type instanceof Factory ? $type->model() : $type::class;

        return (new $modelName)->getMorphClass();
    }
}

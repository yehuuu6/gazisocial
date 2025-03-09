<?php

namespace Database\Factories\ZalimKasaba;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ZalimKasaba\Lobby>
 */
class LobbyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'host_id' => 1,
            'name' => $this->faker->word,
        ];
    }
}

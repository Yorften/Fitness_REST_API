<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::inRandomOrder()->pluck('id')->first();
        return [
            'name' => fake()->sentence(),
            'weight' => fake()->randomFloat(3, 20, 300),
            'height' => fake()->randomFloat(2, 1.60, 2.20),
            'chest_measurement' => fake()->randomFloat(2, 80, 130),
            'waist_measurement' => fake()->randomFloat(2, 65, 110),
            'hips_measurement' => fake()->randomFloat(2, 85, 140),
            'distance_run' => fake()->numberBetween(500, 5000),
            'user_id' => $user_id,
        ];
    }
}

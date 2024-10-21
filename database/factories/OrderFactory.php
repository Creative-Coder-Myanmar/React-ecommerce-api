<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => 'confirmed',
            'total_amount' => fake()->numberBetween(100, 1000),
            'address' => fake()->address(),
            'screen_shot' => fake()->imageUrl(640, 480),
            'notes' => fake()->text(),
            'user_id' => User::factory()
        ];
    }
}

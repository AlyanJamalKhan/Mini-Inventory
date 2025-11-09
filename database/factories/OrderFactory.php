<?php

namespace Database\Factories;

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
            'customer_id' => null, // You'll often link this manually in tests or seeders
            'total_amount' => fake()->randomFloat(2, 10, 5000), // Example range
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            // 'created_at' will usually be set automatically
            // Add other attributes if necessary
        ];
    }
}
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => null, // You'll often link this manually
            'product_id' => null, // You'll often link this manually
            'quantity' => fake()->numberBetween(1, 10), // Example quantity
            'price' => fake()->randomFloat(2, 1, 500), // Example price
            // Add other attributes if necessary
        ];
    }
}
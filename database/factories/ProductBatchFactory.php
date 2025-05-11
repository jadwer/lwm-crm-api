<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\ProductBatch>
 */
class ProductBatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => 1,
            'batch_number' => $this->faker->uuid,
            'expiration_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'quantity' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}

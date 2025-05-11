<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\Stock>
 */
class StockFactory extends Factory
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
            'warehouse_id' => 1,
            'warehouse_location_id' => null,
            'quantity' => $this->faker->randomFloat(2, 0, 500),
            'average_cost' => $this->faker->randomFloat(2, 10, 1000),
            'stock_min' => 10,
            'stock_max' => 200,
            'reorder_point' => 50,
        ];
    }
}

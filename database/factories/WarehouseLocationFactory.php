<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\WarehouseLocation>
 */
class WarehouseLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warehouse_id' => 1,
            'name' => $this->faker->word . ' ' . $this->faker->randomElement(['A', 'B', 'C']),
            'type' => $this->faker->randomElement(['pasillo', 'estante', 'zona']),
        ];
    }
}

<?php

// Archivo: database/factories/WarehouseFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class WarehouseFactory extends Factory
{
    public function definition(): array
    {
        // Usar un manager existente si hay usuarios creados
        $manager = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'name' => 'Almacén ' . $this->faker->city(),
            'location' => $this->faker->address(),
            'manager_id' => $manager->id,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}

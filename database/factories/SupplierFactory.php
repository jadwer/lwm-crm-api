<?php

// Archivo: database/factories/SupplierFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        $company = $this->faker->unique()->company();

        return [
            'name' => $company,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'rfc' => strtoupper(Str::random(13)),
        ];
    }
}

<?php

// Archivo: database/factories/UnitFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    public function definition(): array
    {
        $units = [
            ['name' => 'Litros', 'code' => 'L', 'type' => 'volumen'],
            ['name' => 'Mililitros', 'code' => 'ml', 'type' => 'volumen'],
            ['name' => 'Gramos', 'code' => 'g', 'type' => 'peso'],
            ['name' => 'Kilogramos', 'code' => 'kg', 'type' => 'peso'],
            ['name' => 'Piezas', 'code' => 'pz', 'type' => 'unidad'],
            ['name' => 'Cajas', 'code' => 'cj', 'type' => 'unidad'],
            ['name' => 'Frascos', 'code' => 'fras', 'type' => 'unidad'],
            ['name' => 'Unidades', 'code' => 'u', 'type' => 'unidad'],
            ['name' => 'Paquetes', 'code' => 'paq', 'type' => 'unidad'],
            ['name' => 'Tubos', 'code' => 'tubo', 'type' => 'unidad'],
        ];

        $unit = $this->faker->randomElement($units);
        $suffix = $this->faker->unique()->numerify('###');

        return [
            'name' => $unit['name'] . " " . $suffix,
            'code' => $unit['code'] . '-' . $suffix,
            'type' => $unit['type'],
        ];
    }
}

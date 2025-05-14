<?php

// Archivo: database/factories/CategoryFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Reactivos',
            'Medios de cultivo',
            'Cristalería',
            'Análisis de agua',
            'Proceso',
            'Instrumentación',
            'Control de calidad',
            'Consumibles',
            'Vidriería de laboratorio',
            'Sistemas de medición'
        ]);

        $suffix = $this->faker->numerify('###'); // entropía simple

        return [
            'name' => $name . ' ' . $suffix,
            'description' => $name,
            'slug' => Str::slug($name . '-' . $suffix),
        ];
    }
}

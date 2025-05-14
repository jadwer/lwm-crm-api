<?php

// Archivo: database/factories/BrandFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
{
    public function definition(): array
    {
        $base = $this->faker->randomElement([
            'Thermo Fisher',
            'Merck',
            'BRAND',
            'HACH',
            'HIGH PURITY',
            'J. T. BAKER',
            'MACRON',
            'WHATMAN',
            'SigmaLab',
            'EppendorfTech',
            'Hanna',
            'Velab',
            'AtagoPlus',
            'OhausLabs',
            'ParmerTech',
            'IKA Scientific',
            'QuantLab',
            'BioTools',
            'Nexus',
            'LabPro'
        ]);

        $suffix = $this->faker->randomElement([
            ' S.A. de C.V.',
            ' Co.',
            ' & Asociados',
            ' de México',
            ' Industrial',
            ' Corp.',
            ' Internacional',
            '',
        ]);

        $name = $base . $suffix;

        $slug = Str::slug($base) . '-' . $this->faker->unique()->numerify('###');

        return [
            'name' => $name,
            'description' => "Productos de la marca $name",
            'slug' => $slug,
        ];
    }
}

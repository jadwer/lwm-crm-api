<?php

// Archivo: database/factories/ProductFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Brand;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $unit = Unit::inRandomOrder()->first() ?? Unit::factory()->create();
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
        $brand = Brand::inRandomOrder()->first() ?? Brand::factory()->create();

        $cost = $this->faker->randomFloat(2, 200, 9000);
        $price = $this->faker->randomFloat(2, $cost + 100, $cost + 2000);
        $sku = 'LWM-PRD-' . str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT);
        $name = $this->faker->randomElement([
            'Microscopio binocular óptico',
            'Balanza analítica de precisión',
            'Agitador magnético con calefacción',
            'Centrífuga de alta velocidad',
            'Refractómetro digital portátil',
            'PH-metro de laboratorio',
            'Estufa de secado digital',
            'Cámara de flujo laminar',
            'Congelador ultra bajo (-86°C)',
            'Baño María termostatado'
        ]);

        return [
            'name' => $name,
            'description' => $this->faker->sentence(8),
            'full_description' => $this->faker->paragraph(3),
            'sku' => $sku,
            'cost' => $cost,
            'price' => $price,
            'iva' => $this->faker->boolean(),
            'img_path' => 'https://via.placeholder.com/600x400?text=Producto+de+Laboratorio',
            'datasheet_path' => 'https://example.com/datasheets/sample.pdf',
            'unit_id' => $unit->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ];
    }
}

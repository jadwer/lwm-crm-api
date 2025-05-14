<?php

// Archivo: database/factories/ProductBatchFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseLocation;

class ProductBatchFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $warehouse = Warehouse::inRandomOrder()->first() ?? Warehouse::factory()->create();
        $location = WarehouseLocation::inRandomOrder()->first() ?? WarehouseLocation::factory()->create();

        return [
            'product_id' => $product->id,
            'batch_number' => 'LWT-' . now()->format('Y') . '-' . $this->faker->unique()->numberBetween(10000, 99999),
            'quantity' => $this->faker->numberBetween(10, 100),
            'entry_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+2 years'),
            'warehouse_id' => $warehouse->id,
            'warehouse_location_id' => $location->id,
        ];
    }
}

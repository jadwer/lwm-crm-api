<?php

// Archivo: database/factories/StockFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseLocation;

class StockFactory extends Factory
{
    public function definition(): array
    {

        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $warehouse = Warehouse::inRandomOrder()->first() ?? Warehouse::factory()->create();
        $location = WarehouseLocation::inRandomOrder()->first() ?? WarehouseLocation::factory()->create();

        return [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'warehouse_location_id' => $location->id,
            'quantity' => $this->faker->numberBetween(0, 100),
            'average_cost' => $this->faker->randomFloat(2, 100, 10000),
            'stock_min' => 10,
            'stock_max' => 200,
            'reorder_point' => 50,        ];
    }
}

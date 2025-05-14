<?php

// Archivo: database/factories/PurchaseOrderItemFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\PurchaseOrder;

class PurchaseOrderItemFactory extends Factory
{
    public function definition(): array
    {

        $order = PurchaseOrder::inRandomOrder()->first() ?? PurchaseOrder::factory()->create();
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();

        $quantity = $this->faker->numberBetween(1, 20);
        $unitPrice = $this->faker->randomFloat(2, 10, 1000);

        return [
            'purchase_order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $quantity * $unitPrice,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;

class SalesOrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sales_order_id' => SalesOrder::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'unit_price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'subtotal' => $this->faker->randomFloat(2, 0, 99999999.99),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PurchaseOrder;
use App\Models\Supplier;

class PurchaseOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseOrder::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'order_date' => fake()->date(),
            'status' => fake()->randomElement(["pending","approved","received","cancelled"]),
            'total_amount' => fake()->randomFloat(2, 0, 99999999.99),
            'notes' => fake()->text(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\SalesOrder;

class SalesOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrder::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'order_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(["pending","confirmed","shipped","delivered","cancelled"]),
            'total_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'notes' => $this->faker->text(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'sku' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'description' => $this->faker->text(),
            'full_description' => $this->faker->text(),
            'img_path' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'datasheet_path' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'unit_id' => Unit::factory(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}

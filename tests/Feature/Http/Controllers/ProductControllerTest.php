<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\HttpTestAssertions;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductController
 */
final class ProductControllerTest extends TestCase
{
    use HttpTestAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson(route('products.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'store',
            \App\Http\Requests\ProductStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $name = $this->faker->word();
        $description = $this->faker->sentence();
        $full_description = $this->faker->text();
        $unit = Unit::factory()->create();
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        $response = $this->postJson(route('products.store'), [
            'name' => $name,
            'description' => $description,
            'full_description' => $full_description,
            'unit_id' => $unit->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $products = Product::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('full_description', $full_description)
            ->where('unit_id', $unit->id)
            ->where('category_id', $category->id)
            ->where('brand_id', $brand->id)
            ->get();
        $this->assertCount(1, $products);
        $product = $products->first();

        $response->assertCreated();
        $response->assertJson([
            'id' => $product->id,
            'name' => $name,
        ]);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('products.show', $product));

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'full_description',
            'unit_id',
            'category_id',
            'brand_id'
        ]);
    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'update',
            \App\Http\Requests\ProductUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $product = Product::factory()->create();
        $name = $this->faker->word();
        $description = $this->faker->sentence();
        $full_description = $this->faker->text();
        $unit = Unit::factory()->create();
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        $response = $this->putJson(route('products.update', $product), [
            'name' => $name,
            'description' => $description,
            'full_description' => $full_description,
            'unit_id' => $unit->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $product->refresh();

        $response->assertOk();
        $response->assertJson([
            'id' => $product->id,
            'name' => $name,
        ]);

        $this->assertEquals($name, $product->name);
        $this->assertEquals($description, $product->description);
        $this->assertEquals($full_description, $product->full_description);
        $this->assertEquals($unit->id, $product->unit_id);
        $this->assertEquals($category->id, $product->category_id);
        $this->assertEquals($brand->id, $product->brand_id);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $product = Product::factory()->create();

        $response = $this->deleteJson(route('products.destroy', $product));

        $response->assertNoContent();
        $this->assertModelMissing($product);
    }
}

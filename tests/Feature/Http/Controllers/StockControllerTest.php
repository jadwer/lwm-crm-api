<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\HttpTestAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\StockController
 */
final class StockControllerTest extends TestCase
{
    use HttpTestAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();

        Stock::factory()->count(3)->create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
        ]);

        $response = $this->getJson(route('stock.index'));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $stock = Stock::factory()->create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
        ]);

        $response = $this->getJson(route('stock.show', $stock));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'product_id',
                'warehouse_id',
                'quantity',
                'average_cost',
            ]
        ]);
    }

    #[Test]
    public function store_saves(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $quantity = $this->faker->randomFloat(2, 1, 100);
        $average_cost = $this->faker->randomFloat(2, 10, 1000);

        $response = $this->postJson(route('stock.store'), [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => $quantity,
            'average_cost' => $average_cost,
        ]);

        $stock = Stock::where('product_id', $product->id)
                      ->where('warehouse_id', $warehouse->id)
                      ->first();

        $this->assertNotNull($stock);
        $response->assertCreated();
        $response->assertJson([
            'data' => [
                'id' => $stock->id,
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
            ]
        ]);
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $stock = Stock::factory()->create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
        ]);

        $new_quantity = $this->faker->randomFloat(2, 50, 150);
        $new_cost = $this->faker->randomFloat(2, 20, 2000);

        $response = $this->putJson(route('stock.update', $stock), [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => $new_quantity,
            'average_cost' => $new_cost,
        ]);

        $stock->refresh();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $stock->id,
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
            ]
        ]);

        $this->assertEquals($new_quantity, $stock->quantity);
        $this->assertEquals($new_cost, $stock->average_cost);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $stock = Stock::factory()->create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
        ]);

        $response = $this->deleteJson(route('stock.destroy', $stock));

        $response->assertNoContent();
        $this->assertModelMissing($stock);
    }
}

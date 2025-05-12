<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SalesOrderItem;
use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SalesOrderItemController
 */
final class SalesOrderItemControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function index_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        SalesOrderItem::factory()->count(3)->create();

        $response = $this->getJson(route('sales-order-items.index'));

        $response->assertOk();
    }

    #[Test]
    public function store_creates_sales_order_item(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $order = SalesOrder::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'sales_order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'unit_price' => 450.00,
            'subtotal' => 1350.00
        ];

        $response = $this->postJson(route('sales-order-items.store'), $data);

        $response->assertCreated();
        $this->assertDatabaseHas('sales_order_items', [
            'sales_order_id' => $order->id,
            'product_id' => $product->id,
            'subtotal' => 1350.00
        ]);
    }

    #[Test]
    public function show_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $item = SalesOrderItem::factory()->create();

        $response = $this->getJson(route('sales-order-items.show', $item));

        $response->assertOk();
    }

    #[Test]
    public function update_modifies_sales_order_item(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $item = SalesOrderItem::factory()->create();
        $order = SalesOrder::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'sales_order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'unit_price' => 500.00,
            'subtotal' => 2500.00
        ];

        $response = $this->putJson(route('sales-order-items.update', $item), $data);

        $response->assertOk();
        $this->assertDatabaseHas('sales_order_items', [
            'id' => $item->id,
            'quantity' => 5,
            'subtotal' => 2500.00
        ]);
    }

    #[Test]
    public function destroy_deletes_sales_order_item(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $item = SalesOrderItem::factory()->create();

        $response = $this->deleteJson(route('sales-order-items.destroy', $item));

        $response->assertNoContent();
        $this->assertModelMissing($item);
    }
}

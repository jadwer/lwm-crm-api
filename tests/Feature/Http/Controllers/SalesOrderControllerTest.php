<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SalesOrderController
 */
final class SalesOrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function index_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        SalesOrder::factory()->count(3)->create();

        $response = $this->getJson(route('sales-orders.index'));

        $response->assertOk();
    }

    #[Test]
    public function store_creates_sales_order(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $customer = Customer::factory()->create();
        $product = \App\Models\Product::factory()->create([
            'price' => 100,
        ]);

        $data = [
            'customer_id' => $customer->id,
            'order_date' => now()->toDateString(),
            'status' => 'pending',
            'notes' => 'Venta generada en test',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'unit_price' => 100.00,
                    'subtotal' => 200.00,
                ],
            ],
        ];

        $response = $this->postJson(route('sales-orders.store'), $data);

        $response->assertCreated();
        $this->assertDatabaseHas('sales_orders', [
            'customer_id' => $customer->id,
            'status' => 'pending',
            'total_amount' => 200.00,
        ]);
        $this->assertDatabaseHas('sales_order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
            'subtotal' => 200.00,
        ]);
    }

    #[Test]
    public function show_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $salesOrder = SalesOrder::factory()->create();

        $response = $this->getJson(route('sales-orders.show', $salesOrder));

        $response->assertOk();
    }

    #[Test]
    public function update_modifies_sales_order(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $order = SalesOrder::factory()->create();
        $customer = Customer::factory()->create();
        $product = \App\Models\Product::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'order_date' => now()->addDay()->toDateString(),
            'status' => 'confirmed',
            'notes' => 'Modificación desde test',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 3,
                    'unit_price' => 450.00,
                    'subtotal' => 1350.00,
                ]
            ],
        ];

        $response = $this->putJson(route('sales-orders.update', $order), $data);

        $response->assertOk();
        $this->assertDatabaseHas('sales_orders', [
            'id' => $order->id,
            'status' => 'confirmed',
            'total_amount' => 1350.00,
        ]);
        $this->assertDatabaseHas('sales_order_items', [
            'sales_order_id' => $order->id,
            'product_id' => $product->id,
            'subtotal' => 1350.00,
        ]);
    }

    #[Test]
    public function destroy_deletes_sales_order(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $salesOrder = SalesOrder::factory()->create();

        $response = $this->deleteJson(route('sales-orders.destroy', $salesOrder));

        $response->assertNoContent();
        $this->assertModelMissing($salesOrder);
    }
}

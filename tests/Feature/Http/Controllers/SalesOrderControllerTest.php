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

        $data = [
            'customer_id' => $customer->id,
            'order_date' => Carbon::now()->toDateString(),
            'status' => 'pending',
            'total_amount' => 1999.99,
            'notes' => 'Pedido urgente'
        ];

        $response = $this->postJson(route('sales-orders.store'), $data);

        $response->assertCreated();
        $this->assertDatabaseHas('sales_orders', [
            'customer_id' => $customer->id,
            'status' => 'pending',
            'total_amount' => 1999.99,
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

        $salesOrder = SalesOrder::factory()->create();
        $customer = Customer::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'order_date' => now()->addDay()->toDateString(),
            'status' => 'confirmed',
            'total_amount' => 2450.00,
            'notes' => 'Actualización desde test'
        ];

        $response = $this->putJson(route('sales-orders.update', $salesOrder), $data);

        $response->assertOk();
        $this->assertDatabaseHas('sales_orders', [
            'id' => $salesOrder->id,
            'status' => 'confirmed',
            'total_amount' => 2450.00,
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

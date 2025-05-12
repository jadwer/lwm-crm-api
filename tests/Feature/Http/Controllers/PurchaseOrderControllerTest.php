<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PurchaseOrderController
 */
final class PurchaseOrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function test_index_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        PurchaseOrder::factory()->count(3)->create();

        $response = $this->getJson(route('purchase-orders.index'));

        $response->assertOk();
    }

    #[Test]
    public function test_store_creates_purchase_order(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $supplier = Supplier::factory()->create();

        $data = [
            'supplier_id' => $supplier->id,
            'order_date' => now()->toDateString(),
            'status' => 'pending',
            'total_amount' => 1234.56,
            'notes' => 'Orden de prueba'
        ];

        $response = $this->postJson(route('purchase-orders.store'), $data);

        $response->assertCreated();

        $this->assertDatabaseHas('purchase_orders', [
            'supplier_id' => $supplier->id,
            'total_amount' => 1234.56,
        ]);
    }

    #[Test]
    public function test_show_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->getJson(route('purchase-orders.show', $purchaseOrder));

        $response->assertOk();
    }

    #[Test]
    public function test_update_modifies_purchase_order(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $purchaseOrder = PurchaseOrder::factory()->create();
        $supplier = Supplier::factory()->create();

        $data = [
            'supplier_id' => $supplier->id,
            'order_date' => now()->addDay()->toDateString(),
            'status' => 'approved',
            'total_amount' => 999.99,
            'notes' => 'Actualización desde test'
        ];

        $response = $this->putJson(route('purchase-orders.update', $purchaseOrder), $data);

        $response->assertOk();

        $purchaseOrder->refresh();

        $this->assertEquals($data['supplier_id'], $purchaseOrder->supplier_id);
        $this->assertEquals($data['status'], $purchaseOrder->status);
        $this->assertEquals($data['total_amount'], $purchaseOrder->total_amount);
    }

    #[Test]
    public function test_destroy_deletes_purchase_order(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->deleteJson(route('purchase-orders.destroy', $purchaseOrder));

        $response->assertNoContent();
        $this->assertModelMissing($purchaseOrder);
    }
}

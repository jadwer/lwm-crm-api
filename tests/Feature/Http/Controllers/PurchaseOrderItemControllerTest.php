<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * @see \App\Http\Controllers\PurchaseOrderItemController
 */
final class PurchaseOrderItemControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function test_index_returns_ok(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        PurchaseOrderItem::factory()->count(3)->create();

        $response = $this->getJson(route('purchase-order-items.index'));

        $response->assertOk();
    }

    #[Test]
    public function test_store_creates_purchase_order_item(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $product = Product::factory()->create();
        $purchaseOrder = PurchaseOrder::factory()->create();

        $data = [
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'unit_price' => 100.00,
            'subtotal' => 500.00
        ];

        $response = $this->postJson(route('purchase-order-items.store'), $data);

        $response->assertCreated();

        $this->assertDatabaseHas('purchase_order_items', [
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' => $product->id,
        ]);
    }

    #[Test]
    public function test_show_returns_ok(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $item = PurchaseOrderItem::factory()->create();

        $response = $this->getJson(route('purchase-order-items.show', $item));

        $response->assertOk();
    }

    #[Test]
    public function test_update_modifies_purchase_order_item(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $item = PurchaseOrderItem::factory()->create();
        $newProduct = Product::factory()->create();

        $data = [
            'purchase_order_id' => $item->purchase_order_id, // Ensure the correct purchase order ID is used
            'product_id' => $newProduct->id,
            'quantity' => 10,
            'unit_price' => 150.00,
            'subtotal' => 1500.00
        ];

        $response = $this->putJson(route('purchase-order-items.update', $item), $data);

        $response->assertOk();

        $item->refresh();

        $this->assertEquals($data['quantity'], $item->quantity);
        $this->assertEquals($data['unit_price'], $item->unit_price);
        $this->assertEquals($data['subtotal'], $item->subtotal);
    }

    #[Test]
    public function test_destroy_deletes_purchase_order_item(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $item = PurchaseOrderItem::factory()->create();

        $response = $this->deleteJson(route('purchase-order-items.destroy', $item));

        $response->assertNoContent();
        $this->assertModelMissing($item);
    }
}

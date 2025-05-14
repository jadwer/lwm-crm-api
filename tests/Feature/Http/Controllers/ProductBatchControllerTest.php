<?php

// Archivo: tests/Feature/Http/Controllers/ProductBatchControllerTest.php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Warehouse;
use App\Models\WarehouseLocation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductBatchControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function store_saves_product_batch()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();
        $location = WarehouseLocation::factory()->create(['warehouse_id' => $warehouse->id]);

        $batch_number = 'BN-TEST-001';
        $quantity = 10;

        $response = $this->postJson(route('product-batches.store'), [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'warehouse_location_id' => $location->id,
            'batch_number' => $batch_number,
            'quantity' => $quantity,
        ]);

        $batches = ProductBatch::where('batch_number', $batch_number)->get();
        $this->assertCount(1, $batches);

        $batch = $batches->first();

        $response->assertCreated();
        $response->assertJson([
            'data' => [
                'id' => $batch->id,
                'batch_number' => $batch->batch_number,
                'quantity' => $batch->quantity,
            ],
        ]);
    }

    /** @test */
    public function update_behaves_as_expected()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $batch = ProductBatch::factory()->create();
        $warehouse = Warehouse::factory()->create();
        $location = WarehouseLocation::factory()->create(['warehouse_id' => $warehouse->id]);

        $batch_number = 'BN-UPDATED-123';

        $response = $this->putJson(route('product-batches.update', $batch), [
            'product_id' => $batch->product_id,
            'warehouse_id' => $warehouse->id,
            'warehouse_location_id' => $location->id,
            'batch_number' => $batch_number,
            'quantity' => 99,
        ]);

        $batch->refresh();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $batch->id,
                'batch_number' => $batch_number,
                'quantity' => 99,
            ],
        ]);
    }
}

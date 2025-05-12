<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\HttpTestAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductBatchController
 */
final class ProductBatchControllerTest extends TestCase
{
    use HttpTestAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $product = Product::factory()->create();
        ProductBatch::factory()->count(3)->create(['product_id' => $product->id]);

        $response = $this->getJson(route('product-batches.index'));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $product = Product::factory()->create();
        $batch = ProductBatch::factory()->create(['product_id' => $product->id]);

        $response = $this->getJson(route('product-batches.show', $batch));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'product_id',
                'batch_number',
                'expiration_date',
                'quantity',
            ]
        ]);
    }

    #[Test]
    public function store_saves(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $product = Product::factory()->create();
        $batch_number = strtoupper($this->faker->bothify('BATCH###'));
        $expiration_date = now()->addMonths(6)->toDateString();
        $quantity = $this->faker->randomFloat(2, 1, 100);

        $response = $this->postJson(route('product-batches.store'), [
            'product_id' => $product->id,
            'batch_number' => $batch_number,
            'expiration_date' => $expiration_date,
            'quantity' => $quantity,
        ]);

        $batches = ProductBatch::where('batch_number', $batch_number)->get();
        $this->assertCount(1, $batches);
        $batch = $batches->first();

        $response->assertCreated();
        $response->assertJson([
            'data' => [
                'id' => $batch->id,
                'batch_number' => $batch_number,
            ]
        ]);
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $product = Product::factory()->create();
        $batch = ProductBatch::factory()->create([
            'product_id' => $product->id,
        ]);

        $batch_number = strtoupper($this->faker->bothify('NEW###'));
        $expiration_date = now()->addMonths(12)->toDateString();
        $quantity = $this->faker->randomFloat(2, 1, 100);

        $response = $this->putJson(route('product-batches.update', $batch), [
            'product_id' => $product->id,
            'batch_number' => $batch_number,
            'expiration_date' => $expiration_date,
            'quantity' => $quantity,
        ]);

        $batch->refresh();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $batch->id,
                'batch_number' => $batch_number,
            ]
        ]);

        $this->assertEquals($batch_number, $batch->batch_number);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $product = Product::factory()->create();
        $batch = ProductBatch::factory()->create([
            'product_id' => $product->id
        ]);

        $response = $this->deleteJson(route('product-batches.destroy', $batch));

        $response->assertNoContent();
        $this->assertModelMissing($batch);
    }
}

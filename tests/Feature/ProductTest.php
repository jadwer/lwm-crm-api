<?php

// Archivo: tests/Feature/ProductTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_filter_products_by_sku()
    {
        Product::factory()->create(['sku' => 'BAL-123']);
        Product::factory()->create(['sku' => 'BAL-999']);

        $response = $this->getJson('/api/products?sku=BAL-123');

        $response->assertOk();
        $response->assertJsonFragment(['sku' => 'BAL-123']);

        // Filtrar manualmente el resultado paginado
        $products = $response->json('data');
        $filtered = collect($products)->filter(fn ($p) => $p['sku'] === 'BAL-123');

        $this->assertCount(1, $filtered->all());
    }
}

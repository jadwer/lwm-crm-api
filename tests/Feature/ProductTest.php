<?php
// Archivo: tests/Feature/ProductTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;

/**
 * Pruebas funcionales del modelo Product vía API.
 * Este archivo verifica que los filtros del scopeFilters funcionen correctamente.
 */
class ProductTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
   
    public function it_can_filter_products_by_sku()
    {
        $unit = Unit::factory()->create();
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();

        Product::factory()->create([
            'name' => 'Balanza Analítica',
            'sku' => 'BAL-123',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'unit_id' => $unit->id,
        ]);

        Product::factory()->create([
            'name' => 'Balanza de Precisión',
            'sku' => 'BAL-999',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'unit_id' => $unit->id,
        ]);

        $response = $this->getJson('/api/products?sku=BAL-123');

        $response->assertOk();
        $response->assertJsonFragment(['sku' => 'BAL-123']);
        $response->assertJsonMissing(['sku' => 'BAL-999']);
    }
}

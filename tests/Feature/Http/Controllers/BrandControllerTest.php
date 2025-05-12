<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use JMac\Testing\Traits\HttpTestAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BrandController
 */
final class BrandControllerTest extends TestCase
{
    use HttpTestAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $brands = Brand::factory()->count(3)->create();

        $response = $this->getJson(route('brands.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BrandController::class,
            'store',
            \App\Http\Requests\BrandStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $name = $this->faker->company;
        $description = $this->faker->sentence;
        $slug = Str::slug($name);

        $response = $this->postJson(route('brands.store'), [
            'name' => $name,
            'description' => $description,
            'slug' => $slug,
        ]);

        $brands = Brand::where('name', $name)->get();
        $this->assertCount(1, $brands);
        $brand = $brands->first();

        $response->assertCreated();
        $response->assertJson([
            'id' => $brand->id,
            'name' => $name,
        ]);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->getJson(route('brands.show', $brand));

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'slug'
        ]);
    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BrandController::class,
            'update',
            \App\Http\Requests\BrandUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $brand = Brand::factory()->create();
        $name = $this->faker->company;
        $description = $this->faker->sentence;
        $slug = Str::slug($name);

        $response = $this->putJson(route('brands.update', $brand), [
            'name' => $name,
            'description' => $description,
            'slug' => $slug,
        ]);

        $brand->refresh();

        $response->assertOk();
        $response->assertJson([
            'id' => $brand->id,
            'name' => $name,
        ]);

        $this->assertEquals($name, $brand->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $brand = Brand::factory()->create();

        $response = $this->deleteJson(route('brands.destroy', $brand));

        $response->assertNoContent();
        $this->assertModelMissing($brand);
    }
}

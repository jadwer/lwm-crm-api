<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\HttpTestAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\WarehouseController
 */
final class WarehouseControllerTest extends TestCase
{
    use HttpTestAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        Warehouse::factory()->count(3)->create();

        $response = $this->getJson(route('warehouses.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data',
        ]);
    }

    #[Test]
    public function store_saves(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $name = $this->faker->company;
        $location = $this->faker->address;
        $notes = $this->faker->optional()->sentence;

        $response = $this->postJson(route('warehouses.store'), [
            'name' => $name,
            'location' => $location,
            'notes' => $notes,
        ]);

        $warehouses = Warehouse::where('name', $name)->get();
        $this->assertCount(1, $warehouses);
        $warehouse = $warehouses->first();

        $response->assertCreated();
        $response->assertJson([
            'data' => [
                'id' => $warehouse->id,
                'name' => $name,
            ]
        ]);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $warehouse = Warehouse::factory()->create();

        $response = $this->getJson(route('warehouses.show', $warehouse));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'location',
                'notes',
            ]
        ]);
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $warehouse = Warehouse::factory()->create();

        $name = $this->faker->company;
        $location = $this->faker->address;
        $notes = $this->faker->sentence;

        $response = $this->putJson(route('warehouses.update', $warehouse), [
            'name' => $name,
            'location' => $location,
            'notes' => $notes,
        ]);

        $warehouse->refresh();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $warehouse->id,
                'name' => $name,
            ]
        ]);

        $this->assertEquals($name, $warehouse->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $warehouse = Warehouse::factory()->create();

        $response = $this->deleteJson(route('warehouses.destroy', $warehouse));

        $response->assertNoContent();
        $this->assertModelMissing($warehouse);
    }
}

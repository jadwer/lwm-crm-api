<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseLocation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\HttpTestAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\WarehouseLocationController
 */
final class WarehouseLocationControllerTest extends TestCase
{
    use HttpTestAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $warehouse = Warehouse::factory()->create();
        WarehouseLocation::factory()->count(3)->create([
            'warehouse_id' => $warehouse->id
        ]);

        $response = $this->getJson(route('warehouse-locations.index'));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $warehouse = Warehouse::factory()->create();
        $location = WarehouseLocation::factory()->create([
            'warehouse_id' => $warehouse->id
        ]);

        $response = $this->getJson(route('warehouse-locations.show', $location));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'type',
                'warehouse_id',
            ]
        ]);
    }

    #[Test]
    public function store_saves(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $warehouse = Warehouse::factory()->create();
        $name = $this->faker->word();
        $type = $this->faker->randomElement(['pasillo', 'estante']);

        $response = $this->postJson(route('warehouse-locations.store'), [
            'warehouse_id' => $warehouse->id,
            'name' => $name,
            'type' => $type,
        ]);

        $locations = WarehouseLocation::where('name', $name)->get();
        $this->assertCount(1, $locations);
        $location = $locations->first();

        $response->assertCreated();
        $response->assertJson([
            'data' => [
                'id' => $location->id,
                'name' => $name,
            ]
        ]);
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $warehouse = Warehouse::factory()->create();
        $location = WarehouseLocation::factory()->create([
            'warehouse_id' => $warehouse->id
        ]);

        $name = $this->faker->word();
        $type = $this->faker->randomElement(['pasillo', 'estante']);

        $response = $this->putJson(route('warehouse-locations.update', $location), [
            'name' => $name,
            'type' => $type,
            'warehouse_id' => $warehouse->id,
        ]);

        $location->refresh();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $location->id,
                'name' => $name,
            ]
        ]);

        $this->assertEquals($name, $location->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $warehouse = Warehouse::factory()->create();
        $location = WarehouseLocation::factory()->create([
            'warehouse_id' => $warehouse->id
        ]);

        $response = $this->deleteJson(route('warehouse-locations.destroy', $location));

        $response->assertNoContent();
        $this->assertModelMissing($location);
    }
}

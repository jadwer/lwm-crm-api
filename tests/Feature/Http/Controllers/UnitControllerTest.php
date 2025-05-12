<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\HttpTestAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UnitController
 */
final class UnitControllerTest extends TestCase
{
    use HttpTestAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        Unit::factory()->count(3)->create();

        $response = $this->getJson(route('units.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitController::class,
            'store',
            \App\Http\Requests\UnitStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $name = $this->faker->word();

        $response = $this->postJson(route('units.store'), [
            'name' => $name,
        ]);

        $units = Unit::query()->where('name', $name)->get();
        $this->assertCount(1, $units);
        $unit = $units->first();

        $response->assertCreated();
        $response->assertJson([
            'id' => $unit->id,
            'name' => $name,
        ]);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $unit = Unit::factory()->create();

        $response = $this->getJson(route('units.show', $unit));

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
        ]);
    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitController::class,
            'update',
            \App\Http\Requests\UnitUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $unit = Unit::factory()->create();
        $name = $this->faker->word();

        $response = $this->putJson(route('units.update', $unit), [
            'name' => $name,
        ]);

        $unit->refresh();

        $response->assertOk();
        $response->assertJson([
            'id' => $unit->id,
            'name' => $name,
        ]);

        $this->assertEquals($name, $unit->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $unit = Unit::factory()->create();

        $response = $this->deleteJson(route('units.destroy', $unit));

        $response->assertNoContent();
        $this->assertModelMissing($unit);
    }
}

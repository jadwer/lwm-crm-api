<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * @see \App\Http\Controllers\SupplierController
 */
final class SupplierControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function test_index_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        Supplier::factory()->count(3)->create();

        $response = $this->getJson(route('suppliers.index'));

        $response->assertOk();
    }

    #[Test]
    public function test_store_creates_supplier(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $data = [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'rfc' => $this->faker->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}')
        ];

        $response = $this->postJson(route('suppliers.store'), $data);

        $response->assertCreated();

        $this->assertDatabaseHas('suppliers', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    #[Test]
    public function test_show_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $supplier = Supplier::factory()->create();

        $response = $this->getJson(route('suppliers.show', $supplier));

        $response->assertOk();
    }

    #[Test]
    public function test_update_modifies_supplier(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $supplier = Supplier::factory()->create();

        $data = [
            'name' => 'Proveedor Actualizado',
            'email' => 'nuevo@correo.test',
            'phone' => '5551234567',
            'address' => 'Nueva dirección',
            'rfc' => 'XAXX010101000'
        ];

        $response = $this->putJson(route('suppliers.update', $supplier), $data);

        $response->assertOk();

        $supplier->refresh();

        $this->assertEquals($data['name'], $supplier->name);
        $this->assertEquals($data['email'], $supplier->email);
    }

    #[Test]
    public function test_destroy_deletes_supplier(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $supplier = Supplier::factory()->create();

        $response = $this->deleteJson(route('suppliers.destroy', $supplier));

        $response->assertNoContent();
        $this->assertModelMissing($supplier);
    }
}

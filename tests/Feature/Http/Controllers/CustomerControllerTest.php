<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CustomerController
 */
final class CustomerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function index_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        Customer::factory()->count(3)->create();

        $response = $this->getJson(route('customers.index'));

        $response->assertOk();
    }

    #[Test]
    public function store_creates_customer(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'rfc' => 'ABC123456789',
        ];

        $response = $this->postJson(route('customers.store'), $data);

        $response->assertCreated();
        $this->assertDatabaseHas('customers', ['name' => $data['name']]);
    }

    #[Test]
    public function show_returns_ok(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $customer = Customer::factory()->create();

        $response = $this->getJson(route('customers.show', $customer));

        $response->assertOk();
    }

    #[Test]
    public function update_modifies_customer(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $customer = Customer::factory()->create();

        $data = ['name' => 'Cliente Actualizado'];

        $response = $this->putJson(route('customers.update', $customer), $data);

        $response->assertOk();
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Cliente Actualizado']);
    }

    #[Test]
    public function destroy_deletes_customer(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $customer = Customer::factory()->create();

        $response = $this->deleteJson(route('customers.destroy', $customer));

        $response->assertNoContent();
        $this->assertModelMissing($customer);
    }
}

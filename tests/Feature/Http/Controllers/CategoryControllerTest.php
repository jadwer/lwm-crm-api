<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use JMac\Testing\Traits\HttpTestAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CategoryController
 */
final class CategoryControllerTest extends TestCase
{
    use HttpTestAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson(route('categories.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryController::class,
            'store',
            \App\Http\Requests\CategoryStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $name = $this->faker->word;
        $description = $this->faker->sentence;
        $slug = Str::slug($name);

        $response = $this->postJson(route('categories.store'), [
            'name' => $name,
            'description' => $description,
            'slug' => $slug,
        ]);

        $categories = Category::where('name', $name)->get();
        $this->assertCount(1, $categories);
        $category = $categories->first();

        $response->assertCreated();
        $response->assertJson([
            'id' => $category->id,
            'name' => $name,
        ]);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $category = Category::factory()->create();

        $response = $this->getJson(route('categories.show', $category));

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
            \App\Http\Controllers\CategoryController::class,
            'update',
            \App\Http\Requests\CategoryUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $category = Category::factory()->create();
        $name = $this->faker->word;
        $description = $this->faker->sentence;
        $slug = Str::slug($name);

        $response = $this->putJson(route('categories.update', $category), [
            'name' => $name,
            'description' => $description,
            'slug' => $slug,
        ]);

        $category->refresh();

        $response->assertOk();
        $response->assertJson([
            'id' => $category->id,
            'name' => $name,
        ]);

        $this->assertEquals($name, $category->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $category = Category::factory()->create();

        $response = $this->deleteJson(route('categories.destroy', $category));

        $response->assertNoContent();
        $this->assertModelMissing($category);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory()->count(5)->create();
        Category::factory()->create([
            'name' => "Reactivos",
            'description' => "Reactivos",
            'slug' => "reactivos",
        ]);
        Category::factory()->create([
            'name' => "Medios de cultivo",
            'description' => "Medios de cultivo",
            'slug' => "medios-de-cultivo",
        ]);
        Category::factory()->create([
            'name' => "Cristalería",
            'description' => "Cristalería",
            'slug' => "cristaleria",
        ]);
        Category::factory()->create([
            'name' => "Análisis de agua",
            'description' => "Análisis de agua",
            'slug' => "analisis-de-agua",
        ]);
        Category::factory()->create([
            'name' => "Proceso",
            'description' => "Proceso",
            'slug' => "proceso",
        ]);
    }
}

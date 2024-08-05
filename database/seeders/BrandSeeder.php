<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Brand::factory()->count(5)->create();
        Brand::factory()->create([
            'name' => 'MERCK',
            'description' => 'MERCK',
            'slug' => 'merck',
        ]);
        Brand::factory()->create([
            'name' => 'BRAND',
            'description' => 'BRAND',
            'slug' => 'brand',
        ]);
        Brand::factory()->create([
            'name' => 'HACH',
            'description' => 'HACH',
            'slug' => 'hach',
        ]);
        Brand::factory()->create([
            'name' => 'HIGH PURITY',
            'description' => 'HIGH PURITY',
            'slug' => 'high-purity',
        ]);
        Brand::factory()->create([
            'name' => 'J. T. BAKER',
            'description' => 'J. T. BAKER',
            'slug' => 'j-t-baker',
        ]);
        Brand::factory()->create([
            'name' => 'MACRON',
            'description' => 'MACRON',
            'slug' => 'macron',
        ]);
        Brand::factory()->create([
            'name' => 'WHATMAN',
            'description' => 'WHATMAN',
            'slug' => 'whatman',
        ]);
    }
}

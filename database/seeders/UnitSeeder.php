<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Unit::factory()->count(5)->create();
        Unit::factory()->create([
            'type' => 'pz',
            'code' => 'pz',
            'name' => 'Pieza',
        ]);
        Unit::factory()->create([
            'type' => 'box',
            'code' => 'bx',
            'name' => 'Caja',
        ]);
    }
}

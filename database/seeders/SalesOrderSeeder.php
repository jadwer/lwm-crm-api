<?php

// Archivo: database/seeders/SalesOrderSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesOrder;

class SalesOrderSeeder extends Seeder
{
    public function run(): void
    {
        SalesOrder::factory()->count(10)->create();
    }
}

<?php

// Archivo: database/seeders/SalesOrderItemSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesOrderItem;

class SalesOrderItemSeeder extends Seeder
{
    public function run(): void
    {
        SalesOrderItem::factory()->count(10)->create();
    }
}

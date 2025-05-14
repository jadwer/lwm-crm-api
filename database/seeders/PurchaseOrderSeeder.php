<?php

// Archivo: database/seeders/PurchaseOrderSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        PurchaseOrder::factory()->count(10)->create();
    }
}

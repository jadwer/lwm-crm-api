<?php

// Archivo: database/seeders/PurchaseOrderItemSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrderItem;

class PurchaseOrderItemSeeder extends Seeder
{
    public function run(): void
    {
        PurchaseOrderItem::factory()->count(10)->create();
    }
}

<?php

// Archivo: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UnitSeeder::class,
            UserSeeder::class,
            GabinoUserSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            WarehouseSeeder::class,
            WarehouseLocationSeeder::class,
            ProductSeeder::class,
            ProductBatchSeeder::class,
            StockSeeder::class,
            PurchaseOrderSeeder::class,
            PurchaseOrderItemSeeder::class,
            SalesOrderSeeder::class,
            SalesOrderItemSeeder::class
        ]);
    }
}

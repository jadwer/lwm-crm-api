<?php

// Archivo: database/seeders/GabinoUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GabinoUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'jadwer@msn.com'],
            [
                'name' => 'Gabino Ramírez',
                'password' => Hash::make('123'),
            ]
        );
    }
}

<?php

// Archivo: app/Console/Commands/SeedWithLogging.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SeedWithLogging extends Command
{
    protected $signature = 'db:seed-verbose';
    protected $description = 'Ejecuta todos los seeders mostrando progreso en consola y log.';

    public function handle()
    {
        $this->info("⏳ Iniciando ejecución de seeders...");
        $inicio = now();

        // Ejecutar el seeding completo
        Artisan::call('db:seed', [], $this->getOutput());

        // Logging en archivo
        Log::info("[Seeder] Ejecutado correctamente a las " . now());

        $fin = now();
        $duracion = $inicio->diffInSeconds($fin);

        $this->info("✅ Todos los seeders se ejecutaron correctamente.");
        $this->info("🕒 Duración total: {$duracion} segundos.");
    }
}

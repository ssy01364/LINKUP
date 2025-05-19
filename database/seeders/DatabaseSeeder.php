<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SectorSeeder;
use Database\Seeders\ServicioSeeder;
// use Database\Seeders\UsuarioSeeder;
// use Database\Seeders\EmpresaSeeder;
// use Database\Seeders\DisponibilidadSeeder;
// use Database\Seeders\CitaSeeder;
// use Database\Seeders\ValoracionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llama a cada uno de tus seeders en el orden adecuado.
        $this->call([
            RoleSeeder::class,
            SectorSeeder::class,
            ServicioSeeder::class,
            // Cuando los hayas creado, descomenta estas líneas:
            // UsuarioSeeder::class,
            // EmpresaSeeder::class,
            // DisponibilidadSeeder::class,
            // CitaSeeder::class,
            // ValoracionSeeder::class,
        ]);
    }
}

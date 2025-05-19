<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
    /**
     * Seed the sectores table.
     */
    public function run(): void
    {
        // Genera 10 sectores con datos Faker,
        // pero solo los inserta si no existen ya.
        Sector::factory()
            ->count(10)
            ->make()            // genera instancias sin guardar
            ->each(function ($sector) {
                Sector::firstOrCreate(
                    ['nombre' => $sector->nombre]
                );
            });
    }
}

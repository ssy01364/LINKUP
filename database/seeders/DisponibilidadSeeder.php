<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disponibilidad;
use App\Models\Empresa;

class DisponibilidadSeeder extends Seeder
{
    public function run(): void
    {
        $empresa = Empresa::first();

        Disponibilidad::firstOrCreate(
            [
                'empresa_id' => $empresa->id,
                'inicio'     => '2025-06-01 09:00:00',
                'fin'        => '2025-06-01 11:00:00',
            ],
            ['disponible' => true]
        );

        Disponibilidad::firstOrCreate(
            [
                'empresa_id' => $empresa->id,
                'inicio'     => '2025-06-01 11:00:00',
                'fin'        => '2025-06-01 13:00:00',
            ],
            ['disponible' => true]
        );
    }
}

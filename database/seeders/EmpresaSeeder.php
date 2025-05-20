<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\Usuario;
use App\Models\Sector;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = Usuario::where('email','empresa1@ejemplo.com')->first();
        $sector  = Sector::first(); // toma el primer sector

        Empresa::firstOrCreate(
            ['usuario_id' => $usuario->id],
            [
                'sector_id'   => $sector->id,
                'nombre'      => 'Consultoría LinkUp',
                'descripcion' => 'Servicios de consultoría y asesoramiento empresarial.',
                'direccion'   => 'Calle Falsa 123, Ciudad',
                'telefono'    => '600123456',
            ]
        );
    }
}

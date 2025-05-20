<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $roleCliente = Role::where('nombre','cliente')->first();
        $roleEmpresa = Role::where('nombre','empresa')->first();

        // Usuario cliente
        Usuario::firstOrCreate(
            ['email' => 'cliente1@ejemplo.com'],
            [
                'nombre'        => 'Cliente Uno',
                'password_hash' => Hash::make('password'),
                'role_id'       => $roleCliente->id,
            ]
        );

        // Usuario empresa
        Usuario::firstOrCreate(
            ['email' => 'empresa1@ejemplo.com'],
            [
                'nombre'        => 'Empresa Uno',
                'password_hash' => Hash::make('password'),
                'role_id'       => $roleEmpresa->id,
            ]
        );
    }
}

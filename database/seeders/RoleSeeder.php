<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['cliente', 'empresa', 'admin'];

        foreach ($roles as $nombre) {
            // Crea el rol solo si no existe
            Role::firstOrCreate(
                ['nombre' => $nombre],
                [] // si quieres fijar timestamps o campos extra, ponlos aquí
            );
        }
    }
}

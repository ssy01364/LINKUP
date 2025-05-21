<?php
// app/Http/Controllers/Empresa/DashboardController.php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $empresa = auth()->user()->empresa;

        // Si por algún motivo no tiene perfil, aborta 404
        if (! $empresa) {
            abort(404, 'Perfil de empresa no encontrado.');
        }

        $total      = $empresa->citas()->count();
        $pendientes = $empresa->citas()
                              ->where('estado', 'pendiente')
                              ->count();

        return view('empresa.dashboard', compact('total', 'pendientes'));
    }
}

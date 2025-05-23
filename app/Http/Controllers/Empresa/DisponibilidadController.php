<?php
// app/Http/Controllers/Empresa/DisponibilidadController.php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Disponibilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisponibilidadController extends Controller
{
    /**
     * GET /empresa/disponibilidades
     */
    public function index()
    {
        // Trae únicamente los slots de la empresa logueada, ordenados por inicio
        $slots = Auth::user()
                     ->empresa
                     ->disponibilidades()
                     ->orderBy('inicio')
                     ->get();

        return view('empresa.disponibilidades.index', compact('slots'));
    }

    /**
     * GET /empresa/disponibilidades/create
     */
    public function create()
    {
        return view('empresa.disponibilidades.create');
    }

    /**
     * POST /empresa/disponibilidades
     */
    public function store(Request $request)
    {
        $request->validate([
            'inicio' => 'required|date',
            'fin'    => 'required|date|after:inicio',
        ]);

        // Crea el nuevo slot en la empresa del usuario autenticado
        Auth::user()
            ->empresa
            ->disponibilidades()
            ->create([
                'inicio'     => $request->input('inicio'),
                'fin'        => $request->input('fin'),
                'disponible' => true,
            ]);

        return redirect()
               ->route('empresa.disponibilidades.index')
               ->with('success', 'Slot añadido correctamente.');
    }

    /**
     * DELETE /empresa/disponibilidades/{id}
     */
    public function destroy($id)
    {
        // Buscamos el slot asegurándonos de que pertenezca a la empresa del usuario
        $slot = Auth::user()
                    ->empresa
                    ->disponibilidades()
                    ->findOrFail($id);

        // Lo eliminamos
        $slot->delete();

        return redirect()
               ->route('empresa.disponibilidades.index')
               ->with('success', 'Slot eliminado correctamente.');
    }
}

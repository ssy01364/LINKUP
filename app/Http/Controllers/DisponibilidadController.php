<?php

namespace App\Http\Controllers;

use App\Models\Disponibilidad;
use Illuminate\Http\Request;

class DisponibilidadController extends Controller
{
    public function index()
    {
        return response()->json(Disponibilidad::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id'  => 'required|exists:empresas,id',
            'inicio'      => 'required|date',
            'fin'         => 'required|date|after:inicio',
            'disponible'  => 'boolean',
        ]);

        return response()->json(Disponibilidad::create($data), 201);
    }

    public function show(Disponibilidad $disponibilidad)
    {
        return response()->json($disponibilidad);
    }

    public function update(Request $request, Disponibilidad $disponibilidad)
    {
        $data = $request->validate([
            'inicio'      => 'sometimes|required|date',
            'fin'         => 'sometimes|required|date|after:inicio',
            'disponible'  => 'boolean',
        ]);

        $disponibilidad->update($data);
        return response()->json($disponibilidad);
    }

    public function destroy(Disponibilidad $disponibilidad)
    {
        $disponibilidad->delete();
        return response()->json(null, 204);
    }
}

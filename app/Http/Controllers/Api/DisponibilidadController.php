<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disponibilidad;
use Illuminate\Http\Request;

class DisponibilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Disponibilidad::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'inicio'     => 'required|date',
            'fin'        => 'required|date|after:inicio',
            'disponible' => 'boolean',
        ]);

        $slot = Disponibilidad::create($data);

        return response()->json($slot, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Disponibilidad $disponibilidad)
    {
        return $disponibilidad;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disponibilidad $disponibilidad)
    {
        $data = $request->validate([
            'inicio'     => 'sometimes|required|date',
            'fin'        => 'sometimes|required|date|after:inicio',
            'disponible' => 'boolean',
        ]);

        $disponibilidad->update($data);

        return $disponibilidad;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disponibilidad $disponibilidad)
    {
        $disponibilidad->delete();

        return response()->json(null, 204);
    }
}

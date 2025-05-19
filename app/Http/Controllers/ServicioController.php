<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        return response()->json(Servicio::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        return response()->json(Servicio::create($data), 201);
    }

    public function show(Servicio $servicio)
    {
        return response()->json($servicio);
    }

    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'nombre'      => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $servicio->update($data);
        return response()->json($servicio);
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return response()->json(null, 204);
    }
}

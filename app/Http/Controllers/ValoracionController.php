<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    public function index()
    {
        return response()->json(Valoracion::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cita_id'     => 'required|exists:citas,id',
            'puntuacion'  => 'required|integer|between:1,5',
            'comentario'  => 'nullable|string',
        ]);

        return response()->json(Valoracion::create($data), 201);
    }

    public function show(Valoracion $valoracion)
    {
        return response()->json($valoracion);
    }

    public function update(Request $request, Valoracion $valoracion)
    {
        $data = $request->validate([
            'puntuacion' => 'sometimes|integer|between:1,5',
            'comentario' => 'nullable|string',
        ]);

        $valoracion->update($data);
        return response()->json($valoracion);
    }

    public function destroy(Valoracion $valoracion)
    {
        $valoracion->delete();
        return response()->json(null, 204);
    }
}

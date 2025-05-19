<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        // Carga sector y servicios en el listado
        return response()->json(
            Empresa::with(['sector', 'servicios'])->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuario_id'  => 'required|exists:usuarios,id',
            'sector_id'   => 'required|exists:sectores,id',
            'nombre'      => 'required|string',
            'descripcion' => 'nullable|string',
            'direccion'   => 'nullable|string',
            'telefono'    => 'nullable|string',
        ]);

        $empresa = Empresa::create($data);

        if ($request->filled('servicios')) {
            $empresa->servicios()->sync($request->input('servicios'));
        }

        return response()->json($empresa->load(['sector','servicios']), 201);
    }

    public function show(Empresa $empresa)
    {
        return response()->json($empresa->load(['sector','servicios','disponibilidades']));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $data = $request->validate([
            'sector_id'   => 'sometimes|required|exists:sectores,id',
            'nombre'      => 'sometimes|required|string',
            'descripcion' => 'nullable|string',
            'direccion'   => 'nullable|string',
            'telefono'    => 'nullable|string',
        ]);

        $empresa->update($data);

        if ($request->filled('servicios')) {
            $empresa->servicios()->sync($request->input('servicios'));
        }

        return response()->json($empresa->load(['sector','servicios']));
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return response()->json(null, 204);
    }
}

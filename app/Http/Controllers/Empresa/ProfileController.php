<?php
namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sector;
use App\Models\Servicio;

class ProfileController extends Controller
{
    /**
     * GET /empresa/profile
     */
    public function edit()
    {
        $empresa   = Auth::user()->empresa;
        $sectores  = Sector::all();
        $servicios = Servicio::all();

        return view('empresa.profile.edit', compact('empresa','sectores','servicios'));
    }

    /**
     * PUT /empresa/profile
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'sector_id'   => 'required|exists:sectores,id',
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'direccion'   => 'nullable|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'servicios'   => 'array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $empresa = Auth::user()->empresa;

        // Actualiza datos básicos
        $empresa->update([
            'sector_id'   => $data['sector_id'],
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? '',
            'direccion'   => $data['direccion'] ?? '',
            'telefono'    => $data['telefono'] ?? '',
        ]);

        // Sincroniza servicios pivot
        $empresa->servicios()->sync($data['servicios'] ?? []);

        return redirect()
               ->route('empresa.profile.edit')
               ->with('success', 'Perfil actualizado correctamente.');
    }
}

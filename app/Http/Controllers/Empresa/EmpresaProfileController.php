<?php
namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmpresaProfileController extends Controller
{
    public function edit()
    {
        $empresa = auth()->user()->empresa;
        return view('empresa.profile.edit', compact('empresa'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
          'sector_id'   => 'required|exists:sectores,id',
          'nombre'      => 'required|string|max:100',
          'descripcion' => 'nullable|string',
          'direccion'   => 'nullable|string',
          'telefono'    => 'nullable|string',
        ]);

        auth()->user()->empresa->update($data);
        return redirect()->route('empresa.dashboard')
                         ->with('success','Perfil actualizado');
    }
}

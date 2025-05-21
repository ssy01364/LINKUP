<?php
namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disponibilidad;

class DisponibilidadController extends Controller
{
    public function index()
    {
        $slots = auth()->user()->empresa->disponibilidades;
        return view('empresa.disponibilidades.index', compact('slots'));
    }

    public function create()
    {
        return view('empresa.disponibilidades.create');
    }

    public function store(Request $r)
    {
        $r->validate([
          'inicio'=>'required|date|after:now',
          'fin'   =>'required|date|after:inicio',
        ]);

        auth()->user()->empresa
            ->disponibilidades()
            ->create($r->only('inicio','fin')+['disponible'=>true]);

        return redirect()->route('empresa.disponibilidades.index')
                         ->with('success','Slot añadido');
    }

    public function destroy(Disponibilidad $disponibilidad)
    {
        $disponibilidad->delete();
        return back()->with('success','Slot eliminado');
    }
}

<?php
namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;

class CitaController extends Controller
{
    public function index()
    {
        $citas = auth()->user()
                       ->empresa
                       ->citas()
                       ->with('cliente','servicio')
                       ->get();

        return view('empresa.citas.index', compact('citas'));
    }

    public function confirmar(Cita $cita)
    {
        $cita->update(['estado'=>'confirmada']);
        return back()->with('success','Cita confirmada');
    }

    public function cancelar(Cita $cita)
    {
        $cita->update(['estado'=>'cancelada']);
        // libera el slot
        $cita->empresa
             ->disponibilidades()
             ->where('inicio',$cita->fecha_inicio)
             ->where('fin',$cita->fecha_fin)
             ->update(['disponible'=>true]);

        return back()->with('success','Cita cancelada');
    }
}

<?php
// app/Http/Controllers/Empresa/CitaController.php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Disponibilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    /**
     * GET /empresa/citas
     * Mostrar todas las citas de la empresa autenticada.
     */
    public function index()
    {
        $citas = Auth::user()
                     ->empresa
                     ->citas()
                     ->with(['cliente', 'servicio'])
                     ->orderBy('fecha_inicio', 'desc')
                     ->get();

        return view('empresa.citas.index', compact('citas'));
    }

    /**
     * PATCH /empresa/citas/{cita}/confirmar
     * Marca la cita como confirmada.
     */
    public function confirmar(Cita $cita)
    {
        // Sólo permite actuar sobre citas de tu propia empresa
        if ($cita->empresa_id !== Auth::user()->empresa->id) {
            abort(403, 'No autorizado');
        }

        $cita->update(['estado' => 'confirmada']);

        return redirect()
               ->route('empresa.citas.index')
               ->with('success', 'Cita confirmada correctamente.');
    }

    /**
     * PATCH /empresa/citas/{cita}/cancelar
     * Marca la cita como cancelada y libera el slot correspondiente.
     */
    public function cancelar(Cita $cita)
    {
        if ($cita->empresa_id !== Auth::user()->empresa->id) {
            abort(403, 'No autorizado');
        }

        // Cambia el estado de la cita
        $cita->update(['estado' => 'cancelada']);

        // Libera el slot
        Disponibilidad::where('empresa_id', $cita->empresa_id)
            ->where('inicio', $cita->fecha_inicio)
            ->where('fin',    $cita->fecha_fin)
            ->update(['disponible' => true]);

        return redirect()
               ->route('empresa.citas.index')
               ->with('success', 'Cita cancelada correctamente.');
    }
}

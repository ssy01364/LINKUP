<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Disponibilidad;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisponibilidadController extends Controller
{
    /**
     * Mostrar listado de slots.
     */
    public function index()
    {
        $slots = Auth::user()->empresa
                     ->disponibilidades()
                     ->orderBy('inicio')
                     ->get();

        return view('empresa.disponibilidades.index', compact('slots'));
    }

    /**
     * Formulario para crear un nuevo slot.
     */
    public function create()
    {
        return view('empresa.disponibilidades.create');
    }

    /**
     * Almacenar nuevo slot.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inicio' => 'required|date',
            'fin'    => 'required|date|after:inicio',
        ]);

        Auth::user()->empresa
            ->disponibilidades()
            ->create([
                'inicio'     => $request->input('inicio'),
                'fin'        => $request->input('fin'),
                'disponible' => true,
            ]);

        return redirect()
               ->route('empresa.disponibilidades.index')
               ->with('success', 'Slot añadido correctamente.');
    }

    /**
     * Eliminar un slot.
     */
    public function destroy($id)
    {
        Auth::user()->empresa
            ->disponibilidades()
            ->findOrFail($id)
            ->delete();

        return redirect()
               ->route('empresa.disponibilidades.index')
               ->with('success', 'Slot eliminado correctamente.');
    }

    /**
     * Vista del calendario de disponibilidades y citas.
     */
    public function calendar()
    {
        
        return view('empresa.disponibilidades.calendar');
    }

    /**
     * Devuelve JSON con eventos (slots + citas) para FullCalendar.
     */
    public function events(Request $request)
    {
        $empresa = Auth::user()->empresa;

        $slotEvents = $empresa->disponibilidades()
            ->get()
            ->map(fn($slot) => [
                'title' => 'Disponible',
                'start' => $slot->inicio->toIso8601String(),
                'end'   => $slot->fin->toIso8601String(),
                'color' => '#28a745',
            ]);

        $citaEvents = Cita::where('empresa_id', $empresa->id)
            ->get()
            ->map(fn($cita) => [
                'title' => ucfirst($cita->estado),
                'start' => $cita->fecha_inicio->toIso8601String(),
                'end'   => $cita->fecha_fin->toIso8601String(),
                'color' => match($cita->estado) {
                    'pendiente'  => '#ffc107',
                    'confirmada' => '#007bff',
                    'finalizada' => '#6c757d',
                    'cancelada'  => '#dc3545',
                },
            ]);

        return response()->json(
            $slotEvents->merge($citaEvents)
        );
    }

    /**
     * GET /empresa/disponibilidades/citas-por-dia?date=YYYY-MM-DD
     * Devuelve JSON con las citas de la empresa para esa fecha.
     */
    public function citasByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $empresa = Auth::user()->empresa;

        $citas = Cita::where('empresa_id', $empresa->id)
            ->whereDate('fecha_inicio', $request->input('date'))
            ->orderBy('fecha_inicio')
            ->get()
            ->map(fn($c) => [
                'cliente'     => $c->cliente->nombre,
                'servicio'    => $c->servicio->nombre,
                'hora_inicio' => $c->fecha_inicio->format('H:i'),
                'hora_fin'    => $c->fecha_fin->format('H:i'),
                'estado'      => ucfirst($c->estado),
            ]);

        return response()->json($citas);
    }
}

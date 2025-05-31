<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Disponibilidad;
use App\Models\Empresa;
use App\Models\Servicio;

class ReservaController extends Controller
{
    /**
     * GET /cliente/reservas
     * Lista todas las citas del cliente autenticado.
     */
    public function index()
    {
        $reservas = Cita::with('empresa', 'servicio')
            ->where('cliente_id', Auth::id())
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('cliente.reservas.index', compact('reservas'));
    }

    /**
     * POST /cliente/book
     * Crea una nueva cita (reserva) a partir de un slot y un servicio
     * que el cliente ha seleccionado en la vista de disponibilidad.
     */
    public function store(Request $request)
    {
        // 1) Validar los datos recibidos
        $data = $request->validate([
            'empresa_id'  => 'required|exists:empresas,id',
            'slot_id'     => 'required|exists:disponibilidades,id',
            'servicio_id' => 'required|exists:servicios,id',
        ]);

        // 2) Verificar que el slot sigue disponible y pertenece a la empresa
        $slot = Disponibilidad::where('id', $data['slot_id'])
            ->where('empresa_id', $data['empresa_id'])
            ->where('disponible', 1)
            ->first();

        if (! $slot) {
            return back()->withErrors(['slot_id' => 'El slot ya no está disponible.']);
        }

        // 3) Crear la cita (reserva)
        Cita::create([
            'cliente_id'   => Auth::id(),
            'empresa_id'   => $data['empresa_id'],
            'servicio_id'  => $data['servicio_id'],
            'fecha_inicio' => $slot->inicio,
            'fecha_fin'    => $slot->fin,
            'estado'       => 'pendiente',
        ]);

        // 4) Marcar el slot como ocupado (disponible = false)
        $slot->update(['disponible' => 0]);

        return redirect()
            ->route('cliente.reservas.index')
            ->with('success', 'Reserva creada correctamente.');
    }

    /**
     * PATCH /cliente/reservas/{cita}/cancelar
     * Cancela una cita propia y libera el slot.
     */
    public function cancel(Cita $cita)
    {
        // 1) Validar que la cita pertenezca al usuario autenticado
        if ($cita->cliente_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // 2) Cambiar estado a 'cancelada'
        $cita->update(['estado' => 'cancelada']);

        // 3) Liberar el slot correspondiente
        Disponibilidad::where('empresa_id', $cita->empresa_id)
            ->where('inicio', $cita->fecha_inicio)
            ->where('fin',    $cita->fecha_fin)
            ->update(['disponible' => 1]);

        return back()->with('success', 'Reserva cancelada correctamente.');
    }
}

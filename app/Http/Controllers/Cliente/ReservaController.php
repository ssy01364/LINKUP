<?php
namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Disponibilidad;

class ReservaController extends Controller
{
    /**
     * GET /cliente/reservas
     * Lista todas las citas del cliente autenticado.
     */
    public function index()
    {
        $reservas = Cita::with('empresa','servicio')
            ->where('cliente_id', Auth::id())
            ->orderBy('fecha_inicio','desc')
            ->get();

        return view('cliente.reservas.index', compact('reservas'));
    }

    /**
     * PATCH /cliente/reservas/{cita}/cancelar
     * Cancela una cita propia y libera el slot.
     */
    public function cancel(Cita $cita)
    {
        // 1) Validar que sea tuya
        if ($cita->cliente_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // 2) Cambiar estado
        $cita->update(['estado' => 'cancelada']);

        // 3) Liberar el slot correspondiente
        Disponibilidad::where('empresa_id', $cita->empresa_id)
            ->where('inicio', $cita->fecha_inicio)
            ->where('fin',    $cita->fecha_fin)
            ->update(['disponible' => true]);

        return back()->with('success', 'Reserva cancelada correctamente.');
    }
}

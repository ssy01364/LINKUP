<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Disponibilidad;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CitaCreadaMail;
use App\Mail\CitaActualizadaMail;

class CitaController extends Controller
{
    /**
     * GET /api/citas
     */
    public function index()
    {
        return response()->json(
            Cita::with(['cliente', 'empresa', 'servicio', 'valoracion'])->get()
        );
    }

    /**
     * POST /api/citas
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id'   => 'required|exists:usuarios,id',
            'empresa_id'   => 'required|exists:empresas,id',
            'servicio_id'  => 'required|exists:servicios,id',
            'fecha_inicio' => 'required|date|after:now',
            'fecha_fin'    => 'required|date|after:fecha_inicio',
        ]);

        // 1) Buscar un slot disponible que cubra el rango solicitado
        $slot = Disponibilidad::where('empresa_id', $data['empresa_id'])
            ->where('disponible', true)
            ->where('inicio', '<=', $data['fecha_inicio'])
            ->where('fin',    '>=', $data['fecha_fin'])
            ->firstOrFail();

        // 2) Crear la cita con estado pendiente
        $cita = Cita::create([
            'cliente_id'   => $data['cliente_id'],
            'empresa_id'   => $data['empresa_id'],
            'servicio_id'  => $data['servicio_id'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin'    => $data['fecha_fin'],
            'estado'       => 'pendiente',
        ]);

        // 3) Marcar el slot como no disponible
        $slot->update(['disponible' => false]);

        // 4) Enviar notificación por email al cliente y a la empresa
        $cliente     = Usuario::findOrFail($data['cliente_id']);
        $empresaUser = $cita->empresa->usuario;

        Mail::to($cliente->email)
            ->queue(new CitaCreadaMail($cita, 'cliente'));

        Mail::to($empresaUser->email)
            ->queue(new CitaCreadaMail($cita, 'empresa'));

        return response()->json(
            $cita->load(['cliente', 'empresa', 'servicio']),
            201
        );
    }

    /**
     * GET /api/citas/{cita}
     */
    public function show(Cita $cita)
    {
        return response()->json(
            $cita->load(['cliente', 'empresa', 'servicio', 'valoracion'])
        );
    }

    /**
     * PUT/PATCH /api/citas/{cita}
     */
    public function update(Request $request, Cita $cita)
    {
        $data = $request->validate([
            'fecha_inicio' => 'sometimes|required|date|after:now',
            'fecha_fin'    => 'sometimes|required|date|after:fecha_inicio',
            'estado'       => 'sometimes|in:pendiente,confirmada,cancelada,finalizada',
        ]);

        $cita->update($data);

        return response()->json($cita);
    }

    /**
     * DELETE /api/citas/{cita}
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();
        return response()->json(null, 204);
    }

    /**
     * PATCH /api/citas/{cita}/confirmar
     */
    public function confirmar(Cita $cita)
    {
        $cita->update(['estado' => 'confirmada']);

        // Notificar a cliente y empresa
        Mail::to($cita->cliente->email)
            ->queue(new CitaActualizadaMail($cita, 'confirmada'));

        Mail::to($cita->empresa->usuario->email)
            ->queue(new CitaActualizadaMail($cita, 'confirmada'));

        return response()->json($cita);
    }

    /**
     * PATCH /api/citas/{cita}/cancelar
     */
    public function cancelar(Cita $cita)
    {
        $cita->update(['estado' => 'cancelada']);

        // Liberar el slot previamente reservado
        Disponibilidad::where('empresa_id', $cita->empresa_id)
            ->where('inicio', $cita->fecha_inicio)
            ->where('fin',    $cita->fecha_fin)
            ->update(['disponible' => true]);

        // Notificar a cliente y empresa
        Mail::to($cita->cliente->email)
            ->queue(new CitaActualizadaMail($cita, 'cancelada'));

        Mail::to($cita->empresa->usuario->email)
            ->queue(new CitaActualizadaMail($cita, 'cancelada'));

        return response()->json($cita);
    }
}

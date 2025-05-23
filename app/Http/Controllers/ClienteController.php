<?php
// app/Http/Controllers/ClienteController.php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Servicio;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disponibilidad;
use App\Models\Cita;

class ClienteController extends Controller
{
    /**
     * 1. Muestra el formulario de búsqueda
     */
    public function searchForm()
    {
        $sectores  = Sector::all();
        $servicios = Servicio::all();

        return view('cliente.search-form', compact('sectores', 'servicios'));
    }

    /**
     * 2. Procesa el filtro y muestra empresas
     */
    public function search(Request $request)
    {
        $request->validate([
            'sector_id'   => 'nullable|exists:sectores,id',
            'servicios'   => 'array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $empresas = Empresa::with('servicios')
            ->when($request->sector_id, function($q, $sectorId) {
                $q->where('sector_id', $sectorId);
            })
            ->when($request->servicios, function($q, $servicios) {
                $q->whereHas('servicios', function($q2) use ($servicios) {
                    $q2->whereIn('servicio_id', $servicios);
                });
            })
            ->get();

        return view('cliente.search-results', compact('empresas'));
    }

    /**
     * 3. Lista los slots disponibles de la empresa
     */
    public function availability(Empresa $empresa)
    {
        // Traemos solo los slots disponibles
        $slots = $empresa
            ->disponibilidades()
            ->where('disponible', true)
            ->orderBy('inicio')
            ->get();

        return view('cliente.availability', compact('empresa', 'slots'));
    }

    /**
     * 4. Reserva un slot (crea cita + bloquea slot)
     */
    public function book(Request $request)
    {
        $data = $request->validate([
            'empresa_id'  => 'required|exists:empresas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'slot_id'     => 'required|exists:disponibilidad,id',
        ]);

        // Recupera el slot y verifica que siga libre
        $slot = Disponibilidad::where('id', $data['slot_id'])
            ->where('disponible', true)
            ->firstOrFail();

        // Crea la cita
        Cita::create([
            'cliente_id'   => Auth::id(),
            'empresa_id'   => $data['empresa_id'],
            'servicio_id'  => $data['servicio_id'],
            'fecha_inicio' => $slot->inicio,
            'fecha_fin'    => $slot->fin,
            'estado'       => 'pendiente',
        ]);

        // Marca el slot como ocupado
        $slot->update(['disponible' => false]);

        return redirect()
            ->route('cliente.availability', $data['empresa_id'])
            ->with('success', 'Cita reservada con éxito.');
    }
}

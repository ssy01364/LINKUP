{{-- resources/views/empresa/citas/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Citas Recibidas')

@section('content')
  <h1 class="mb-4">Citas Recibidas</h1>

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Cliente</th>
        <th>Servicio</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Estado</th>
        <th class="text-end">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($citas as $cita)
        <tr>
          <td>{{ $cita->cliente->nombre }}</td>
          <td>{{ $cita->servicio->nombre }}</td>
          <td>{{ $cita->fecha_inicio->format('d/m/Y H:i') }}</td>
          <td>{{ $cita->fecha_fin->format('d/m/Y H:i') }}</td>
          <td>{{ ucfirst($cita->estado) }}</td>
          <td class="text-end">
            @if($cita->estado === 'pendiente')
              <form action="{{ route('empresa.citas.confirmar', $cita) }}"
                    method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-sm btn-success">Confirmar</button>
              </form>
              <form action="{{ route('empresa.citas.cancelar', $cita) }}"
                    method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-sm btn-danger">Cancelar</button>
              </form>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center">No hay citas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection

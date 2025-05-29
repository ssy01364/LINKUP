@extends('layouts.app')

@section('title', 'Mis Reservas')

@section('content')
  <h1 class="mb-4">Mis Reservas</h1>

  {{-- Flash --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Empresa</th>
        <th>Servicio</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Estado</th>
        <th class="text-end">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($reservas as $res)
        <tr>
          <td>{{ $res->empresa->nombre }}</td>
          <td>{{ $res->servicio->nombre }}</td>
          <td>{{ $res->fecha_inicio->format('d/m/Y H:i') }}</td>
          <td>{{ $res->fecha_fin->format('d/m/Y H:i') }}</td>
          <td>{{ ucfirst($res->estado) }}</td>
          <td class="text-end">
            @if($res->estado === 'pendiente')
              <form action="{{ route('cliente.reservas.cancelar', $res) }}"
                    method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-sm btn-danger">
                  Cancelar
                </button>
              </form>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center">
            No tienes reservas.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection

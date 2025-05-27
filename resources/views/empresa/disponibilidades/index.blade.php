{{-- resources/views/empresa/disponibilidades/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Disponibilidades')

@section('content')
  <h1 class="mb-4">Mis Slots de Disponibilidad</h1>

  <a href="{{ route('empresa.disponibilidades.create') }}" class="btn btn-primary mb-3">
    Añadir slot
  </a>

  <table class="table table-hover">
    <thead>
      <tr>
        <th>Inicio</th>
        <th>Fin</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($slots as $slot)
        <tr>
          <td>{{ $slot->inicio->format('d/m/Y H:i') }}</td>
          <td>{{ $slot->fin->format('d/m/Y H:i') }}</td>
          <td class="text-end">
            <form action="{{ route('empresa.disponibilidades.destroy', $slot) }}"
                  method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="text-center">No hay slots definidos.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection

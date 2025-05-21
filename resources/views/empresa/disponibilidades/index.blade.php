@extends('layouts.app')

@section('title','Disponibilidades')

@section('content')
  <h1>Mis Slots de Disponibilidad</h1>
  <a href="{{ route('empresa.disponibilidades.create') }}" class="btn btn-success mb-3">Añadir Slot</a>

  <table class="table">
    <thead>
      <tr><th>Inicio</th><th>Fin</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($slots as $slot)
        <tr>
          <td>{{ $slot->inicio->format('d/m/Y H:i') }}</td>
          <td>{{ $slot->fin->format('d/m/Y H:i') }}</td>
          <td>
            <form action="{{ route('empresa.disponibilidades.destroy',$slot) }}" method="POST">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="3">No hay slots definidos.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection

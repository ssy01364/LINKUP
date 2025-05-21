@extends('layouts.app')

@section('title','Añadir Slot')

@section('content')
  <h1>Añadir Disponibilidad</h1>
  <form action="{{ route('empresa.disponibilidades.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label>Inicio</label>
      <input type="datetime-local" name="inicio"
             class="form-control @error('inicio') is-invalid @enderror">
      @error('inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label>Fin</label>
      <input type="datetime-local" name="fin"
             class="form-control @error('fin') is-invalid @enderror">
      @error('fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button class="btn btn-primary">Guardar Slot</button>
  </form>
@endsection

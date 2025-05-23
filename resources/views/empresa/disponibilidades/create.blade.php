@extends('layouts.app')

@section('title', 'Añadir Slot')

@section('content')
  <h1 class="mb-4">Añadir Disponibilidad</h1>

  {{-- Mensaje de error genérico --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('empresa.disponibilidades.store') }}" method="POST">
    @csrf

    {{-- Necesitamos saber a qué empresa pertenece --}}
    <input type="hidden" name="empresa_id" value="{{ auth()->user()->empresa->id }}">

    <div class="mb-3">
      <label for="inicio" class="form-label">Inicio</label>
      <input type="datetime-local"
             id="inicio"
             name="inicio"
             class="form-control @error('inicio') is-invalid @enderror"
             value="{{ old('inicio') }}"
             required>
      @error('inicio')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="fin" class="form-label">Fin</label>
      <input type="datetime-local"
             id="fin"
             name="fin"
             class="form-control @error('fin') is-invalid @enderror"
             value="{{ old('fin') }}"
             required>
      @error('fin')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-success">Guardar slot</button>
    <a href="{{ route('empresa.disponibilidades.index') }}" class="btn btn-link">Cancelar</a>
  </form>
@endsection

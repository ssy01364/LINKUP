{{-- resources/views/empresa/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Perfil de Empresa')

@section('content')
  <h1 class="mb-4">Editar Perfil de {{ $empresa->nombre }}</h1>

  <form action="{{ route('empresa.profile.update') }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Sector --}}
    <div class="mb-3">
      <label for="sector_id" class="form-label">Sector</label>
      <select name="sector_id" id="sector_id"
              class="form-select @error('sector_id') is-invalid @enderror">
        @foreach($sectores as $sector)
          <option value="{{ $sector->id }}"
            {{ $sector->id == old('sector_id', $empresa->sector_id) ? 'selected' : '' }}>
            {{ $sector->nombre }}
          </option>
        @endforeach
      </select>
      @error('sector_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Nombre --}}
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre de la Empresa</label>
      <input type="text"
             id="nombre"
             name="nombre"
             class="form-control @error('nombre') is-invalid @enderror"
             value="{{ old('nombre', $empresa->nombre) }}"
             required>
      @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Descripción --}}
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea id="descripcion"
                name="descripcion"
                class="form-control @error('descripcion') is-invalid @enderror"
                rows="3">{{ old('descripcion', $empresa->descripcion) }}</textarea>
      @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Dirección --}}
    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección</label>
      <input type="text"
             id="direccion"
             name="direccion"
             class="form-control @error('direccion') is-invalid @enderror"
             value="{{ old('direccion', $empresa->direccion) }}">
      @error('direccion')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Teléfono --}}
    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono</label>
      <input type="text"
             id="telefono"
             name="telefono"
             class="form-control @error('telefono') is-invalid @enderror"
             value="{{ old('telefono', $empresa->telefono) }}">
      @error('telefono')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Servicios --}}
    <div class="mb-3">
      <label class="form-label">Servicios Ofrecidos</label>
      @foreach($servicios as $serv)
        <div class="form-check">
          <input class="form-check-input"
                 type="checkbox"
                 name="servicios[]"
                 value="{{ $serv->id }}"
                 id="serv_{{ $serv->id }}"
                 {{ in_array($serv->id, old('servicios', $empresa->servicios->pluck('id')->toArray())) ? 'checked' : '' }}>
          <label class="form-check-label" for="serv_{{ $serv->id }}">
            {{ $serv->nombre }}
          </label>
        </div>
      @endforeach
      @error('servicios')
        <div class="text-danger">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
  </form>
@endsection

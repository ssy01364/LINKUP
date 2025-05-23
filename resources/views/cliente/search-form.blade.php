@extends('layouts.app')

@section('title', 'Buscar Empresas')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <h1>Buscar Empresas</h1>
    <form action="{{ route('cliente.search.results') }}" method="GET" class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Sector</label>
        <select name="sector_id" class="form-select">
          <option value="">— Todos —</option>
          @foreach($sectores as $sector)
            <option value="{{ $sector->id }}" {{ request('sector_id')==$sector->id?'selected':'' }}>
              {{ $sector->nombre }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Servicios</label>
        <select name="servicios[]" class="form-select" multiple>
          @foreach($servicios as $servicio)
            <option value="{{ $servicio->id }}" 
              {{ in_array($servicio->id, (array)request('servicios', []))?'selected':'' }}>
              {{ $servicio->nombre }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100">Buscar</button>
      </div>
    </form>
  </div>
</div>
@endsection

@extends('layouts.app')
@section('title','Buscar Empresas')
@section('content')
<h1>Buscar Empresas</h1>
<form action="{{ route('cliente.search.results') }}" method="GET" class="row g-3">
  <div class="col-md-4">
    <label>Sector</label>
    <select name="sector_id" class="form-select">
      <option value="">— Todos —</option>
      @foreach($sectores as $s)
        <option value="{{ $s->id }}">{{ $s->nombre }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-6">
    <label>Servicios</label>
    <select name="servicios[]" class="form-select" multiple>
      @foreach($servicios as $srv)
        <option value="{{ $srv->id }}">{{ $srv->nombre }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2 align-self-end">
    <button class="btn btn-primary w-100">Buscar</button>
  </div>
</form>
@endsection

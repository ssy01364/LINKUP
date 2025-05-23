@extends('layouts.app')

@section('title', 'Resultados de Búsqueda')

@section('content')
<h1>Empresas encontradas</h1>

@if($empresas->isEmpty())
  <p>No se encontraron empresas con esos filtros.</p>
@else
  <div class="row">
    @foreach($empresas as $empresa)
      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">{{ $empresa->nombre }}</h5>
            <p class="card-text">{{ $empresa->descripcion }}</p>
            <a 
              href="{{ route('cliente.availability', $empresa) }}" 
              class="btn btn-outline-primary">
              Ver disponibilidad
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endif
@endsection

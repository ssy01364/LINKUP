@extends('layouts.app')
@section('title','Resultados')
@section('content')
<h1>Empresas encontradas</h1>
@if($empresas->isEmpty())
  <p>No se encontraron empresas.</p>
@else
  <div class="row">
    @foreach($empresas as $e)
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-body">
            <h5>{{ $e->nombre }}</h5>
            <p>{{ Str::limit($e->descripcion, 80) }}</p>
            <a href="{{ route('cliente.availability', $e) }}" class="btn btn-sm btn-outline-primary">
              Ver disponibilidad
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endif
@endsection

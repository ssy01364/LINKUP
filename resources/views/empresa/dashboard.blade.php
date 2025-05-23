@extends('layouts.app')

@section('title', 'Dashboard Empresa')

@section('content')
  <h1 class="mb-4">Bienvenido, {{ auth()->user()->nombre }}</h1>

  <div class="row">
    <div class="col-md-6">
      <div class="card text-white bg-primary mb-3">
        <div class="card-header">Total de citas</div>
        <div class="card-body">
          <h5 class="card-title">{{ $total }}</h5>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card text-white bg-warning mb-3">
        <div class="card-header">Citas pendientes</div>
        <div class="card-body">
          <h5 class="card-title">{{ $pendientes }}</h5>
        </div>
      </div>
    </div>
  </div>

  <a href="{{ route('empresa.disponibilidades.index') }}" class="btn btn-success me-2">
    Gestionar Disponibilidades
  </a>
  <a href="{{ route('empresa.citas.index') }}" class="btn btn-secondary">
    Ver Citas
  </a>
@endsection

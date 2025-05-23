{{-- resources/views/empresa/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Empresa')

@section('content')
  <h1 class="mb-4">Bienvenido, {{ auth()->user()->empresa->nombre }}</h1>

  <div class="row mb-4">
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

  <div class="d-flex gap-2">
    <a href="{{ route('empresa.disponibilidades.index') }}" class="btn btn-success">
      Gestionar Disponibilidades
    </a>

    <a href="{{ route('empresa.citas.index') }}" class="btn btn-secondary">
      Ver Citas
    </a>

    <a href="{{ route('empresa.profile.edit') }}" class="btn btn-outline-primary">
      Editar Perfil
    </a>
  </div>
@endsection

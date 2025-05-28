{{-- resources/views/cliente/search-form.blade.php --}}
@extends('layouts.app')

@section('title', 'Buscar Empresas')

@section('content')
  <h1 class="mb-4 text-center">Buscar Empresas</h1>

  {{-- 1) GRID DE CARDS DE SECTORES --}}
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
    @foreach($sectores as $sector)
      <div class="col">
        <div class="card h-100 shadow-sm">
          {{-- Ajusta $sector->imagen al campo que use tu modelo --}}
          <img 
            src="{{ asset('images/'.$sector->imagen) }}" 
            class="card-img-top" 
            alt="{{ $sector->nombre }}" 
            style="height:140px; object-fit:cover;"
          >
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $sector->nombre }}</h5>
            <p class="card-text text-muted mb-4">
              Explora todas las empresas de {{ strtolower($sector->nombre) }}.
            </p>
            <a 
              href="{{ route('cliente.search.results', ['sector_id' => $sector->id]) }}" 
              class="mt-auto btn btn-primary"
            >
              Ver {{ $sector->nombre }}
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- 2) FORMULARIO DE FILTROS --}}
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form action="{{ route('cliente.search.results') }}" method="GET" class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Sector</label>
          <select name="sector_id" class="form-select">
            <option value="">— Todos —</option>
            @foreach($sectores as $sector)
              <option 
                value="{{ $sector->id }}" 
                {{ request('sector_id') == $sector->id ? 'selected' : '' }}
              >
                {{ $sector->nombre }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Servicios</label>
          <select name="servicios[]" class="form-select" multiple>
            @foreach($servicios as $servicio)
              <option 
                value="{{ $servicio->id }}" 
                {{ in_array($servicio->id, (array)request('servicios', [])) ? 'selected' : '' }}
              >
                {{ $servicio->nombre }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-outline-primary w-100">Buscar</button>
        </div>
      </form>
    </div>
  </div>
@endsection

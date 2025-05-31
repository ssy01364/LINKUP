{{-- resources/views/cliente/availability.blade.php --}}
@extends('layouts.app')

@section('title', 'Disponibilidad de ' . $empresa->nombre)

@section('content')
  <h1 class="mb-4">Disponibilidad de {{ $empresa->nombre }}</h1>

  {{-- Si la empresa no tiene servicios --}}
  @if($empresa->servicios->isEmpty())
    <div class="alert alert-warning">
      Esta empresa aún no ha publicado ningún servicio.
    </div>
  @endif

  <div class="row">
    {{-- ==================== COLUMNA IZQUIERDA: FICHA DE LA EMPRESA ==================== --}}
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm">
        <div class="card-body">
          {{-- Nombre de la empresa --}}
          <h3 class="card-title">{{ $empresa->nombre }}</h3>

          {{-- Dirección --}}
          @if($empresa->direccion)
            <p class="mb-1">
              <strong>Dirección:</strong>
              {{ $empresa->direccion }}
            </p>
          @endif

          {{-- Teléfono --}}
          @if($empresa->telefono)
            <p class="mb-3">
              <strong>Teléfono:</strong>
              {{ $empresa->telefono }}
            </p>
          @endif

          {{-- Descripción --}}
          @if($empresa->descripcion)
            <div class="mb-3">
              <strong>Descripción:</strong>
              <p class="text-justify">{{ $empresa->descripcion }}</p>
            </div>
          @endif

          {{-- Lista de servicios ofrecidos --}}
          @if($empresa->servicios->count())
            <div>
              <strong>Servicios ofrecidos:</strong>
              <ul class="list-group list-group-flush mt-2">
                @foreach($empresa->servicios as $servicio)
                  <li class="list-group-item px-0 py-2">
                    <h6 class="mb-1">{{ $servicio->nombre }}</h6>
                    @if($servicio->descripcion)
                      <small class="text-muted">
                        {{ \Illuminate\Support\Str::limit($servicio->descripcion, 100) }}
                      </small>
                    @endif
                  </li>
                @endforeach
              </ul>
            </div>
          @else
            <p class="text-muted"><em>No hay servicios registrados.</em></p>
          @endif
        </div>
      </div>
    </div>

    {{-- ==================== COLUMNA DERECHA: TABLA DE SLOTS + CALENDARIO ==================== --}}
    <div class="col-md-8">
      {{-- 1) Tabla de “Slots disponibles” PRIMERO para que quede alineada al tope --}}
      <h4 class="mb-3">Slots disponibles</h4>

      @if($slots->isEmpty())
        <div class="alert alert-info">
          No hay slots disponibles.
        </div>
      @else
        <table class="table table-bordered">
          <thead class="table-dark">
            <tr>
              <th>Inicio</th>
              <th>Fin</th>
              <th class="text-center">Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach($slots as $slot)
              <tr>
                <td>{{ \Carbon\Carbon::parse($slot->inicio)->format('d/m/Y H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($slot->fin)->format('d/m/Y H:i') }}</td>
                <td class="text-end">
                  <form action="{{ route('cliente.book') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
                    <input type="hidden" name="slot_id" value="{{ $slot->id }}">

                    {{-- Si solo hay un servicio, lo preseleccionamos --}}
                    @if($empresa->servicios->count() === 1)
                      <input
                        type="hidden"
                        name="servicio_id"
                        value="{{ $empresa->servicios->first()->id }}"
                      >
                    @else
                      {{-- Si hay varios servicios, mostramos un select --}}
                      <div class="mb-2">
                        <select
                          name="servicio_id"
                          class="form-select form-select-sm"
                          required
                        >
                          <option value="" disabled selected>
                            Selecciona servicio
                          </option>
                          @foreach($empresa->servicios as $serv)
                            <option value="{{ $serv->id }}">{{ $serv->nombre }}</option>
                          @endforeach
                        </select>
                      </div>
                    @endif

                    <button type="submit" class="btn btn-sm btn-success">
                      Reservar
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif

      {{-- 2) Calendario FullCalendar ABAJO, con margen superior para separarlo --}}
      <div id="calendar" style="min-height: 400px; margin-top: 2rem;"></div>
    </div>
  </div>
@endsection

@push('scripts')
  {{-- FullCalendar JS y CSS desde CDN --}}
  <link
    href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css"
    rel="stylesheet"
  />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let calendarEl = document.getElementById('calendar');

      // Construimos el array de eventos a partir de los slots disponibles
      let events = [
        @foreach($slots as $slot)
          {
            title: "Disponible",
            start: "{{ \Carbon\Carbon::parse($slot->inicio)->toIso8601String() }}",
            end:   "{{ \Carbon\Carbon::parse($slot->fin)->toIso8601String() }}"
          }@if(! $loop->last),@endif
        @endforeach
      ];

      new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
          left:   'prev,next today',
          center: 'title',
          right:  'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: events,
        timeZone: 'local'
      }).render();
    });
  </script>
@endpush

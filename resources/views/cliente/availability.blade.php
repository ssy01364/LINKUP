@extends('layouts.app')

@section('title', 'Disponibilidad')

@section('content')
  <h1>Disponibilidad de {{ $empresa->nombre }}</h1>

  {{-- Mensajes de éxito/error --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Si la empresa no tiene servicios --}}
  @if($empresa->servicios->isEmpty())
    <div class="alert alert-warning">
      Esta empresa aún no ha publicado ningún servicio.
    </div>
  @endif

  <div class="row">
    {{-- Calendario --}}
    <div class="col-md-8">
      <div id="calendar" style="min-height: 400px;"></div>
    </div>

    {{-- Lista de slots --}}
    <div class="col-md-4">
      <h4 class="mb-3">Slots disponibles</h4>

      @if($slots->isEmpty())
        <p>No hay slots disponibles.</p>
      @else
        <table class="table">
          <thead>
            <tr>
              <th>Inicio</th>
              <th>Fin</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($slots as $slot)
              <tr>
                <td>{{ $slot->inicio->format('d/m/Y H:i') }}</td>
                <td>{{ $slot->fin->format('d/m/Y H:i') }}</td>
                <td class="text-end">
                  <form action="{{ route('cliente.book') }}" method="POST" class="d-inline">
                    @csrf
                    {{-- Empresa --}}
                    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
                    {{-- Slot --}}
                    <input type="hidden" name="slot_id"      value="{{ $slot->id }}">

                    @if($empresa->servicios->count() === 1)
                      {{-- Si sólo hay un servicio, lo mandamos oculto --}}
                      <input type="hidden"
                             name="servicio_id"
                             value="{{ $empresa->servicios->first()->id }}">
                    @else
                      {{-- Si hay varios, mostramos un select --}}
                      <div class="mb-2">
                        <select name="servicio_id"
                                class="form-select form-select-sm"
                                required>
                          <option value="" disabled selected>Selecciona servicio</option>
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
    </div>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    // Crear array de eventos
    let events = [
      @foreach($slots as $slot)
      {
        title: "{{ optional($empresa->servicios->first())->nombre ?? 'Disponible' }}",
        start: "{{ $slot->inicio->toIso8601String() }}",
        end:   "{{ $slot->fin->toIso8601String() }}"
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

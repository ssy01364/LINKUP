@extends('layouts.app')

@section('title', 'Disponibilidad')

@section('content')
  <h1>Disponibilidad de {{ $empresa->nombre }}</h1>

  {{-- Placeholder para FullCalendar --}}
  <div id="calendar"></div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    // Nombre del servicio o texto por defecto si no hay ninguno
    const serviceName = "{{ optional($empresa->servicios->first())->nombre ?? 'Disponible' }}";

    // Construye el array de eventos a partir de los slots
    let events = [
      @foreach($slots as $slot)
        {
          title: serviceName,
          start: "{{ $slot->inicio->toIso8601String() }}",
          end:   "{{ $slot->fin->toIso8601String() }}"
        }@if(! $loop->last),@endif
      @endforeach
    ];

    let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left:   'prev,next today',
        center: 'title',
        right:  'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: events,
      timeZone: 'local'
    });

    calendar.render();
  });
</script>
@endpush

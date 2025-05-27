{{-- resources/views/empresa/disponibilidades/calendar.blade.php --}}
@extends('layouts.app')

@section('title', 'Calendario de Citas')

@section('content')
  <h1 class="mb-4">Calendario de Disponibilidades y Citas</h1>

  {{-- Contenedor del calendario --}}
  <div id="calendar" style="max-width:900px;margin:auto;"></div>
  {{-- Listado de citas al hacer clic --}}
  <div id="citas-info" class="mt-4"></div>

  {{-- FullCalendar UMD + locales (incluye DayGrid) --}}
  <link
    href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css"
    rel="stylesheet"
  />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.global.min.js"></script>

  {{-- Estilos: dot tidy --}}
  <style>
    /* Hover sobre el día */
    #calendar .fc-daygrid-day:hover {
      background: #f8f9fa;
      cursor: pointer;
    }
    /* Ocultar barras y text */
    .fc-event {
      background: none !important;
      border: none !important;
      box-shadow: none !important;
    }
    /* Punto circular centrado */
    .fc-event-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      margin: 2px auto;
    }
    /* Oculta “+n más” */
    .fc-daygrid-more-link {
      display: none;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const calendarEl = document.getElementById('calendar');
      const listaEl    = document.getElementById('citas-info');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        // Definimos un botón custom llamado "mes"
        customButtons: {
          mes: {
            text: 'Mes',
            click() {
              calendar.today();                     // ir a hoy
              calendar.changeView('dayGridMonth'); // volver a mes
            }
          }
        },
        headerToolbar: {
          left: 'prev,next today',  // Prev, Next, Hoy
          center: 'title',
          right: 'mes'              // Mes a la derecha
        },
        buttonText: {
          today: 'Hoy'
        },
        displayEventTime: false,

        // Carga tus citas y agrupa fechas únicas
        events(fetchInfo, successCallback, failureCallback) {
          fetch('{{ route("empresa.disponibilidades.events") }}')
            .then(r => r.json())
            .then(data => {
              const fechas = new Set();
              data.forEach(e => {
                // solo citas, no slots
                if (e.title !== 'Disponible') {
                  fechas.add(e.start.substr(0,10));
                }
              });
              // creamos un evento de un día con color fijo
              const eventos = Array.from(fechas).map(fecha => ({
                start: fecha,
                allDay: true,
                color: '#28a745'  // verde para indicar cita existente
              }));
              successCallback(eventos);
            })
            .catch(failureCallback);
        },

        // Dibuja cada evento como un único punto
        eventContent(arg) {
          const color = arg.event.backgroundColor || arg.event.color;
          return {
            html: `<div class="fc-event-dot" style="background:${color}"></div>`
          };
        },

        // Al hacer click en un día, muestra las citas en el div
        dateClick(info) {
          fetch(`{{ route("empresa.disponibilidades.citasDia") }}?date=${info.dateStr}`)
            .then(r => r.json())
            .then(citas => {
              let html = `<h3>Citas para ${info.dateStr}</h3>`;
              if (citas.length) {
                html += '<ul class="list-group">';
                citas.forEach(c => {
                  html += `
                    <li class="list-group-item py-1">
                      <strong>${c.hora_inicio}–${c.hora_fin}</strong>
                      — ${c.cliente} (${c.servicio}) — ${c.estado}
                    </li>`;
                });
                html += '</ul>';
              } else {
                html += '<p>No hay citas para este día.</p>';
              }
              listaEl.innerHTML = html;
            })
            .catch(() => {
              listaEl.innerHTML = '<p>Error al cargar las citas.</p>';
            });
        }
      });

      calendar.render();
    });
  </script>
@endsection

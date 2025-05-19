@component('mail::message')
# Cambio de estado de cita

Tu cita para **{{ $cita->servicio->nombre }}** 
ha sido **{{ $nuevoEstado }}**.

- **Fecha inicio**: {{ $cita->fecha_inicio->format('d/m/Y H:i') }}
- **Fecha fin**: {{ $cita->fecha_fin->format('d/m/Y H:i') }}

Gracias por usar {{ config('app.name') }}.
@endcomponent

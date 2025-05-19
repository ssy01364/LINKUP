@component('mail::message')
# Hola {{ $actor === 'cliente' ? $cita->cliente->nombre : $cita->empresa->usuario->nombre }}

Se ha reservado una cita:

- **Servicio**: {{ $cita->servicio->nombre }}
- **Fecha inicio**: {{ $cita->fecha_inicio->format('d/m/Y H:i') }}
- **Fecha fin**: {{ $cita->fecha_fin->format('d/m/Y H:i') }}

@component('mail::button', ['url' => url('/dashboard')])
Ir al Panel
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title') | {{ config('app.name') }}</title>

  {{-- Bootstrap CSS CDN --}}
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

  {{-- Aquí pueden inyectarse estilos adicionales por vista --}}
  @stack('styles')
</head>
<body>
  @include('partials.navbar')

  <div class="container py-4">
    @include('partials.alerts')
    @yield('content')
  </div>

  {{-- Bootstrap JS Bundle CDN --}}
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js"
  ></script>

  {{-- Aquí pueden inyectarse scripts adicionales por vista --}}
  @stack('scripts')
</body>
</html>

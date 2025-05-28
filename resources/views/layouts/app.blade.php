{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es" id="html-root">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title') | {{ config('app.name') }}</title>

  {{-- Bootstrap CSS CDN --}}
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

  {{-- Dark/Light Mode CSS --}}
  <style>
    /* Light mode (por defecto): blanco y texto negro */
    body {
      background-color: #ffffff;
      color: #000000;
    }

    /* Dark mode: fondo gris muy oscuro, texto claro */
    body.dark-mode {
      background-color: #1e1e1e !important;
      color: #e0e0e0 !important;
    }

    /* Navbar en dark mode */
    body.dark-mode .navbar {
      background-color: #2b2b2b !important;
    }
    /* Enlaces y marca en dark mode */
    body.dark-mode .navbar .nav-link,
    body.dark-mode .navbar-brand {
      color: #f8f9fa !important;
    }

    /* Botones outline deben también invertirse */
    body.dark-mode .btn-outline-secondary {
      color: #f8f9fa;
      border-color: #f8f9fa;
    }
    body.dark-mode .btn-outline-secondary:hover {
      background-color: #444;
      border-color: #f8f9fa;
    }
  </style>

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

  {{-- Dark Mode Toggle Script --}}
  <script>
    (function(){
      const key = 'theme';
      if (localStorage.getItem(key) === 'dark') {
        document.body.classList.add('dark-mode');
      }
      window.toggleTheme = () => {
        const isDark = document.body.classList.toggle('dark-mode');
        localStorage.setItem(key, isDark ? 'dark' : 'light');
      };
    })();
  </script>

  @stack('scripts')
</body>
</html>

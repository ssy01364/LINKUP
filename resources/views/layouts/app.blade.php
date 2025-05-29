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
    /* ----------------------------------------
       Modo claro (por defecto)
    ----------------------------------------- */
    body {
      background-color: #ffffff;
      color: #000000;
    }
    .navbar {
      background-color: #f8f9fa;
    }
    .navbar .nav-link,
    .navbar-brand {
      color: #212529;
    }

    /* Hero (welcome) */
    .hero-light {
      background-color: #f8f9fa;
      color:rgb(34, 35, 36);
    }

    /* Call to Action (footer welcome) */
    .cta-light {
      background-color: #6c757d;
      color: #ffffff;
    }
    .cta-light .btn-cta {
      background-color: #ffffff;
      color: #6c757d;
      border: 1px solid #ffffff;
    }

    /* Botones outline-secondary en claro */
    .btn-outline-secondary {
      color: #6c757d;
      border-color: #6c757d;
    }
    .btn-outline-secondary:hover {
      background-color: #e2e6ea;
    }

    /* Tablas en claro (bootstrap por defecto) */


    /* ----------------------------------------
       Modo oscuro
    ----------------------------------------- */
    body.dark-mode {
      background-color: #1e1e1e !important;
      color: #e0e0e0 !important;
    }

    /* Navbar en oscuro */
    body.dark-mode .navbar {
      background-color: #2b2b2b !important;
    }
    body.dark-mode .navbar .nav-link,
    body.dark-mode .navbar-brand {
      color: #f8f9fa !important;
    }

    /* Hero en oscuro */
    body.dark-mode .hero-light {
      background-color: #2b2b2b !important;
      color: #e0e0e0 !important;
    }

    /* Call to Action en oscuro */
    body.dark-mode .cta-light {
      background-color: #444 !important;
      color: #e0e0e0 !important;
    }
    body.dark-mode .cta-light .btn-cta {
      background-color: #e0e0e0 !important;
      color: #1e1e1e !important;
      border-color: #e0e0e0 !important;
    }

    /* Btn outline-secondary en oscuro */
    body.dark-mode .btn-outline-secondary {
      color: #f8f9fa !important;
      border-color: #f8f9fa !important;
    }
    body.dark-mode .btn-outline-secondary:hover {
      background-color: #444 !important;
      border-color: #f8f9fa !important;
    }

    /* ----------------------------------------
       Tablas en modo oscuro
    ----------------------------------------- */
    /* Tabla base */
    body.dark-mode table {
      background-color: transparent !important;
    }
    /* Encabezado */
    body.dark-mode table thead {
      background-color: #333 !important;
    }
    body.dark-mode table thead th {
      color: #e0e0e0 !important;
      border-color: #444 !important;
    }
    /* Filas */
    body.dark-mode table tbody tr {
      background-color: #2b2b2b !important;
    }
    body.dark-mode table tbody tr:nth-of-type(odd) {
      background-color: #242424 !important;
    }
    /* Celdas */
    body.dark-mode table th,
    body.dark-mode table td {
      color:rgb(17, 16, 16) !important;
      border-color: #444 !important;
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

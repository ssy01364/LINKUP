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

    /* Hero (welcome): un gris suave para que destaque */
    .hero-light {
      background-color: #e9ecef;     /* ⚡ aquí el cambio */
      color: rgb(34, 35, 36);
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
    body.dark-mode table {
      background-color: transparent !important;
    }
    body.dark-mode thead {
      background-color: #333 !important;
    }
    body.dark-mode thead th {
      color: #e0e0e0 !important;
      border-color: #444 !important;
    }
    body.dark-mode tbody tr {
      background-color: #2b2b2b !important;
    }
    body.dark-mode tbody tr:nth-of-type(odd) {
      background-color: #242424 !important;
    }
    body.dark-mode th,
    body.dark-mode td {
      color: #e0e0e0 !important;   /* texto claro */
      border-color: #444 !important;
    }
    
    /* ----------------------------------------
   Footer
----------------------------------------- */
/* Modo claro: un gris oscuro */
.footer-light {
  background-color: #343a40;    /* más oscuro que el cta-light */
  color: #e9ecef;
}
/* Texto de enlace, si lo hubiera */
.footer-light a {
  color: #adb5bd;
}
.footer-light a:hover {
  color: #fff;
}

/* Modo oscuro: aún más oscuro */
body.dark-mode .footer-light {
  background-color: #1a1a1a !important;
  color: #ced4da !important;
}
body.dark-mode .footer-light a {
  color: #888 !important;
}
body.dark-mode .footer-light a:hover {
  color: #e0e0e0 !important;
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
  {{-- Incluimos el footer --}}
  @include('partials.footer')
</body>
</html>

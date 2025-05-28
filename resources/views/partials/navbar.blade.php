{{-- resources/views/partials/navbar.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container d-flex justify-content-between align-items-center">
    {{-- Marca: invitados → welcome, autenticados → home --}}
    <a class="navbar-brand mb-0 h1"
       href="{{ auth()->check() ? route('home') : route('welcome') }}">
      {{ config('app.name') }}
    </a>

    <ul class="navbar-nav ms-auto align-items-center">
      {{-- Botón modo claro/oscuro --}}
      <li class="nav-item me-3">
        <button class="btn btn-outline-secondary btn-sm" onclick="toggleTheme()">
          🌓
        </button>
      </li>

      @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Entrar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Registro</a>
        </li>
      @endguest

      @auth
        @php $rol = auth()->user()->role->nombre; @endphp

        @if($rol === 'cliente')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cliente.search.form') }}">
              Buscar
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cliente.reservas.index') }}">
              Mis Reservas
            </a>
          </li>
        @endif

        @if($rol === 'empresa')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('empresa.dashboard') }}">
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('empresa.disponibilidades.index') }}">
              Disponibilidades
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('empresa.disponibilidades.calendar') }}">
              Calendario
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('empresa.citas.index') }}">
              Citas
            </a>
          </li>
        @endif

        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link nav-link p-0">Salir</button>
          </form>
        </li>
      @endauth
    </ul>
  </div>
</nav>

{{-- resources/views/partials/navbar.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
      {{ config('app.name') }}
    </a>

    <ul class="navbar-nav ms-auto">
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
            <button type="submit" class="btn btn-link nav-link">
              Salir
            </button>
          </form>
        </li>
      @endauth
    </ul>
  </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <ul class="navbar-nav ms-auto">
      @auth
        @if(auth()->user()->role->nombre==='cliente')
          <li class="nav-item"><a class="nav-link" href="{{ route('cliente.search.form') }}">Buscar</a></li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf
              <button class="btn btn-link nav-link">Salir</button>
            </form>
          </li>
        @endif
      @else
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Entrar</a></li>
      @endauth
    </ul>
  </div>
</nav>

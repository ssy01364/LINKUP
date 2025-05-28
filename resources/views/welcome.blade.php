{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'Bienvenido a LinkUp')

@section('content')
  {{-- Hero --}}
  <section class="text-center py-5 bg-light">
    <div class="container">
      <h1 class="display-4 mb-3">¡Bienvenido a LinkUp!</h1>
      <p class="lead mb-4">
        Conecta con las mejores empresas, gestiona tus reservas y mantén tu agenda siempre al día.
      </p>
      <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
        Iniciar sesión
      </a>
      <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">
        Crear cuenta
      </a>
    </div>
  </section>

  {{-- Qué ofrecemos --}}
  <section class="py-5">
    <div class="container">
      <h2 class="mb-4 text-center">¿Qué puedes hacer en LinkUp?</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 text-center">
            <img src="{{ asset('images/EMP1.jpg') }}" class="card-img-top" alt="Búsqueda de empresas">
            <div class="card-body">
              <h5 class="card-title">Buscar Empresas</h5>
              <p class="card-text">
                Explora empresas por sector y servicios. Encuentra lo que necesitas en segundos.
              </p>
            </div>
            <div class="card-footer bg-transparent">
              <a href="{{ route('login') }}" class="btn btn-outline-primary">
                Accede para buscar
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 text-center">
            <img src="{{ asset('images/EMP2.jpg') }}" class="card-img-top" alt="Calendario de citas">
            <div class="card-body">
              <h5 class="card-title">Calendario de Citas</h5>
              <p class="card-text">
                Visualiza tus citas en un calendario interactivo. Organiza tu agenda de forma sencilla.
              </p>
            </div>
            <div class="card-footer bg-transparent">
              <a href="{{ route('login') }}" class="btn btn-outline-primary">
                Regístrate para usarlo
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 text-center">
            <img src="{{ asset('images/EMP3.jpg') }}" class="card-img-top" alt="Gestión de citas">
            <div class="card-body">
              <h5 class="card-title">Gestión de Reservas</h5>
              <p class="card-text">
                Confirma, cancela o revisa el historial de tus reservas con un clic.
              </p>
            </div>
            <div class="card-footer bg-transparent">
              <a href="{{ route('login') }}" class="btn btn-outline-primary">
                Empieza ahora
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Call to Action --}}
  <section class="text-center py-5 bg-secondary text-white">
    <div class="container">
      <h2 class="mb-3">¿A qué esperas?</h2>
      <p class="mb-4">
        Únete a LinkUp y lleva la gestión de tus citas al siguiente nivel.
      </p>
      <a href="{{ route('register') }}" class="btn btn-light btn-lg">Crear cuenta gratis</a>
    </div>
  </section>
@endsection

@extends('layouts.app')

@section('title', 'Entrar')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h1 class="mb-4">Entrar</h1>
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email"
               id="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               required autofocus>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password"
               id="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror"
               required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Entrar</button>
      <a href="{{ route('register') }}" class="btn btn-link">¿No tienes cuenta? Regístrate</a>
    </form>
  </div>
</div>
@endsection

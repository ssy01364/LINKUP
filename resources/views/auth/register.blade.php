@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h1 class="mb-4">Registro</h1>
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre completo</label>
        <input type="text"
               id="nombre"
               name="nombre"
               class="form-control @error('nombre') is-invalid @enderror"
               value="{{ old('nombre') }}"
               required>
        @error('nombre')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email"
               id="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Selector de rol --}}
      <div class="mb-3">
        <label for="role_id" class="form-label">Tipo de cuenta</label>
        <select name="role_id"
                id="role_id"
                class="form-select @error('role_id') is-invalid @enderror"
                required>
          <option value="">— Selecciona un rol —</option>
          @foreach($roles as $role)
            <option value="{{ $role->id }}"
              {{ old('role_id') == $role->id ? 'selected' : '' }}>
              {{ ucfirst($role->nombre) }}
            </option>
          @endforeach
        </select>
        @error('role_id')
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

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               class="form-control"
               required>
      </div>

      <button type="submit" class="btn btn-primary">Registrar</button>
      <a href="{{ route('login') }}" class="btn btn-link">¿Ya tienes cuenta? Entra</a>
    </form>
  </div>
</div>
@endsection

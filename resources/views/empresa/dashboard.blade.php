@extends('layouts.app')

@section('title','Dashboard Empresa')

@section('content')
  <h1>Bienvenido, {{ auth()->user()->nombre }}</h1>
  <p>Total de citas: {{ $total }}</p>
  <p>Citas pendientes: {{ $pendientes }}</p>
  <a href="{{ route('empresa.disponibilidades.index') }}" class="btn btn-primary">Gestionar Disponibilidades</a>
  <a href="{{ route('empresa.citas.index') }}" class="btn btn-secondary">Ver Citas</a>
@endsection

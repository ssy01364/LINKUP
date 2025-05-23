<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Empresa\DashboardController   as EmpresaDash;
use App\Http\Controllers\Empresa\DisponibilidadController as EmpresaDisp;
use App\Http\Controllers\Empresa\CitaController        as EmpresaCita;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí defines las rutas que responden con vistas Blade para tu aplicación
| web. Incluye autenticación, la ruta /home, el panel de cliente
| y el panel de empresa.
|
*/

// 1) Redirige la raíz (/) directamente al login
Route::redirect('/', '/login');

// 2) Rutas de autenticación (login & register) — solo para invitados
Route::middleware('guest')->group(function () {
    Route::get('login',    [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login',   [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register',[AuthController::class, 'register']);
});

// 3) Logout — solo usuarios autenticados
Route::post('logout', [AuthController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

// 4) Ruta /home — tras login/redirección según rol
Route::get('/home', function () {
    $user = auth()->user();

    if ($user->role->nombre === 'empresa') {
        return redirect()->route('empresa.dashboard');
    }

    if ($user->role->nombre === 'cliente') {
        return redirect()->route('cliente.search.form');
    }

    abort(403, 'No tienes permiso para acceder.');
})->middleware('auth')
  ->name('home');

/*
|--------------------------------------------------------------------------
| Panel Cliente
|--------------------------------------------------------------------------
|
| Rutas accesibles únicamente para usuarios con rol "cliente"
| Prefijo: /cliente
| Nombre de ruta: cliente.*
|
*/
Route::middleware(['auth', 'role:cliente'])
     ->prefix('cliente')
     ->name('cliente.')
     ->group(function () {
         // 1. Formulario de búsqueda
         Route::get('buscar',     [ClienteController::class, 'searchForm'])
                                ->name('search.form');

         // 2. Resultados de búsqueda
         Route::get('resultados', [ClienteController::class, 'search'])
                                ->name('search.results');

         // 3. Ver disponibilidad de empresa
         Route::get('empresa/{empresa}/slots', [ClienteController::class, 'availability'])
                                ->name('availability');

         // 4. Reservar un slot
         Route::post('reservar',  [ClienteController::class, 'book'])
                                ->name('book');
     });

/*
|--------------------------------------------------------------------------
| Panel Empresa
|--------------------------------------------------------------------------
|
| Rutas accesibles únicamente para usuarios con rol "empresa"
| Prefijo: /empresa
| Nombre de ruta: empresa.*
|
*/
Route::middleware(['auth', 'role:empresa'])
     ->prefix('empresa')
     ->name('empresa.')
     ->group(function () {
         // a) Dashboard de empresa
         Route::get('dashboard', [EmpresaDash::class, 'index'])
              ->name('dashboard');

         // b) CRUD de disponibilidades: index, create, store, destroy
         Route::resource('disponibilidades', EmpresaDisp::class)
              ->only(['index', 'create', 'store', 'destroy']);

         // c) Gestión de citas
         Route::get('citas',                        [EmpresaCita::class, 'index'])
              ->name('citas.index');
         Route::patch('citas/{cita}/confirmar',     [EmpresaCita::class, 'confirmar'])
              ->name('citas.confirmar');
         Route::patch('citas/{cita}/cancelar',      [EmpresaCita::class, 'cancelar'])
              ->name('citas.cancelar');
     });

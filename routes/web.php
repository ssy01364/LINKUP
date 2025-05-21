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

// Redirige la raíz (/) directamente al formulario de login
Route::redirect('/', '/login');

// Rutas de autenticación (web) para invitados
Route::middleware('guest')->group(function () {
    Route::get('login',    [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login',   [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register',[AuthController::class, 'register']);
});

// Logout (solo usuarios autenticados)
Route::post('logout', [AuthController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

/*
|--------------------------------------------------------------------------
| Ruta /home
|--------------------------------------------------------------------------
|
| Después de login o registro redirige al panel según el rol:
| - empresa → /empresa/dashboard
| - cliente → /cliente/buscar
|
*/
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
| Solo accesible para usuarios con rol "cliente"
|
*/
Route::middleware(['auth', 'role:cliente'])
     ->prefix('cliente')
     ->name('cliente.')
     ->group(function () {
         Route::get('buscar',              [ClienteController::class, 'searchForm'])
                                         ->name('search.form');
         Route::get('resultados',          [ClienteController::class, 'search'])
                                         ->name('search.results');
         Route::get('empresa/{empresa}/slots', [ClienteController::class, 'availability'])
                                         ->name('availability');
         Route::post('reservar',           [ClienteController::class, 'book'])
                                         ->name('book');
     });

/*
|--------------------------------------------------------------------------
| Panel Empresa
|--------------------------------------------------------------------------
|
| Solo accesible para usuarios con rol "empresa"
|
*/
Route::middleware(['auth', 'role:empresa'])
     ->prefix('empresa')
     ->name('empresa.')
     ->group(function () {
         // Dashboard
         Route::get('dashboard', [EmpresaDash::class, 'index'])
              ->name('dashboard');

         // CRUD de disponibilidades (index, create, store, destroy)
         Route::resource('disponibilidades', EmpresaDisp::class)
              ->except(['show','edit','update']);

         // Gestión de citas
         Route::get('citas', [EmpresaCita::class, 'index'])
              ->name('citas.index');
         Route::patch('citas/{cita}/confirmar', [EmpresaCita::class, 'confirmar'])
              ->name('citas.confirmar');
         Route::patch('citas/{cita}/cancelar',  [EmpresaCita::class, 'cancelar'])
              ->name('citas.cancelar');
     });

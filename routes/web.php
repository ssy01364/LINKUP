<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Cliente\ReservaController as ClienteReserva;
use App\Http\Controllers\Empresa\DashboardController   as EmpresaDash;
use App\Http\Controllers\Empresa\DisponibilidadController as EmpresaDisp;
use App\Http\Controllers\Empresa\CitaController        as EmpresaCita;
use App\Http\Controllers\Empresa\ProfileController    as EmpresaProfile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí defines las rutas que responden con vistas Blade para tu aplicación
| web. Incluye autenticación, la ruta /home, el panel de cliente
| y el panel de empresa (disponibilidades, citas, perfil).
|
*/

// 1) Redirige la raíz (/) al login
Route::redirect('/', '/login');

// 2) Autenticación — solo para invitados
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

// 4) /home — redirige tras login según rol
Route::get('/home', function () {
    $user = auth()->user();

    if ($user->role->nombre === 'empresa') {
        return redirect()->route('empresa.dashboard');
    }

    if ($user->role->nombre === 'cliente') {
        return redirect()->route('cliente.search.form');
    }

    abort(403, 'No tienes permiso para acceder.');
})->middleware('auth')->name('home');

/*
|--------------------------------------------------------------------------
| Panel Cliente
|--------------------------------------------------------------------------
| Prefijo: /cliente — Rol: cliente
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

         // 5. Mis Reservas — listado
         Route::get('reservas', [ClienteReserva::class, 'index'])
              ->name('reservas.index');
         // 6. Mis Reservas — cancelar propia
         Route::patch('reservas/{cita}/cancelar', [ClienteReserva::class, 'cancel'])
              ->name('reservas.cancelar');
     });

/*
|--------------------------------------------------------------------------
| Panel Empresa
|--------------------------------------------------------------------------
| Prefijo: /empresa — Rol: empresa
*/
Route::middleware(['auth', 'role:empresa'])
     ->prefix('empresa')
     ->name('empresa.')
     ->group(function () {
         // a) Dashboard
         Route::get('dashboard', [EmpresaDash::class, 'index'])
              ->name('dashboard');

         // b) Perfil de empresa
         Route::get('profile', [EmpresaProfile::class, 'edit'])
              ->name('profile.edit');
         Route::put('profile', [EmpresaProfile::class, 'update'])
              ->name('profile.update');

         // c) CRUD disponibilidades (index, create, store, destroy)
         Route::resource('disponibilidades', EmpresaDisp::class)
              ->only(['index', 'create', 'store', 'destroy']);

         // → Calendario de Disponibilidades y Citas
         // Vista del calendario
         Route::get('disponibilidades/calendar', [EmpresaDisp::class, 'calendar'])
              ->name('disponibilidades.calendar');
         // Endpoint JSON con slots y citas
         Route::get('disponibilidades/events', [EmpresaDisp::class, 'events'])
              ->name('disponibilidades.events');
         // Listado de citas por día seleccionado
         Route::get('disponibilidades/citas-por-dia', [EmpresaDisp::class, 'citasByDate'])
              ->name('disponibilidades.citasDia');

         // d) Gestión de citas: listar, confirmar y cancelar
         Route::get('citas',                        [EmpresaCita::class, 'index'])
              ->name('citas.index');
         Route::patch('citas/{cita}/confirmar',     [EmpresaCita::class, 'confirmar'])
              ->name('citas.confirmar');
         Route::patch('citas/{cita}/cancelar',      [EmpresaCita::class, 'cancelar'])
              ->name('citas.cancelar');
     });

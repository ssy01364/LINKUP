<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí defines las rutas que responden con vistas Blade para tu aplicación
| web. Incluye autenticación, la ruta /home y el panel de cliente.
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

// Ruta /home redirige al buscador de cliente
Route::get('/home', function () {
    return redirect()->route('cliente.search.form');
})->middleware(['auth', 'role:cliente'])
  ->name('home');

// Panel Cliente (autenticado y con rol "cliente")
Route::middleware(['auth', 'role:cliente'])
     ->prefix('cliente')
     ->name('cliente.')
     ->group(function () {
         // Formulario de búsqueda
         Route::get('buscar',     [ClienteController::class, 'searchForm'])
                                ->name('search.form');

         // Resultados de búsqueda
         Route::get('resultados', [ClienteController::class, 'search'])
                                ->name('search.results');

         // Disponibilidad de una empresa
         Route::get('empresa/{empresa}/slots', [ClienteController::class, 'availability'])
                                ->name('availability');

         // Reservar un slot
         Route::post('reservar',  [ClienteController::class, 'book'])
                                ->name('book');
     });

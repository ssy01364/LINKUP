<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\DisponibilidadController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ValoracionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas de tu API. Todas ellas responderán en /api/...
|
*/

// Rutas públicas de autenticación
Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

// Rutas protegidas por Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout']);

    // Recursos API: index, show, store, update, destroy
    Route::apiResource('sectores',         SectorController::class);
    Route::apiResource('servicios',        ServicioController::class);
    Route::apiResource('empresas',         EmpresaController::class);
    Route::apiResource('disponibilidades', DisponibilidadController::class);
    Route::apiResource('citas',            CitaController::class);
    Route::apiResource('valoraciones',     ValoracionController::class);

    // Endpoints para cambiar estado de cita
    Route::patch('citas/{cita}/confirmar', [CitaController::class, 'confirmar']);
    Route::patch('citas/{cita}/cancelar',  [CitaController::class, 'cancelar']);

    // Retorna el usuario autenticado
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});

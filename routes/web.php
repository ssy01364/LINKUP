<?php

use Illuminate\Support\Facades\Route;

// Rutas de tu API, autenticación y demás...
// Route::post(...);
// Route::get('/api/...');

// Catch-all para servir tu SPA React, excluyendo las rutas de Vite y Sanctum
Route::get('/{any}', function () {
    return view('app');
})
// Solo intercepta rutas que NO empiecen por:
//    api/      <- tu API
//    sanctum/  <- csrf-cookie, login, logout
//    @vite    <- todos los endpoints de HMR de Vite
//    vite_ping <- ping interno de Vite
//    favicon.ico, robots.txt...
->where('any', '^(?!api/|sanctum/|@vite/|vite_ping$|favicon.ico|robots.txt).');


Route::get('/{any}', fn()=> view('app'))
     ->where('any','^(?!api).$');
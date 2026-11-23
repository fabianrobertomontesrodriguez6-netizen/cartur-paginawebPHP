<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas web del concesionario CarTur
|--------------------------------------------------------------------------
*/

// Página de aterrizaje con animación de auto en movimiento
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Catálogo de autos con barra de tareas por marca
Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog');

// Detalle de un auto en concreto
Route::get('/catalogo/{car}', [CatalogController::class, 'show'])->name('catalog.show');

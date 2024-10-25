<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VeterinarioController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\AmoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoriasController;
use App\Http\Controllers\ConsultasController;



// Route::post('/login-superuser', [AuthController::class, 'login']);
Route::post('/veterinario/login', [VeterinarioController::class, 'login']);
Route::post('/veterinario/register', [VeterinarioController::class, 'register']) -> name('veterinario.register');



// Rutas para veterinarios y Amos, autenticadas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Rutas para gestionar mascotas
    Route::post('/mascotas-store', [MascotaController::class, 'store']);
    Route::get('/mascotas', [MascotaController::class, 'index']);
    Route::get('/mascotas/{id}', [MascotaController::class, 'show']);
    Route::put('/mascotas/{id}', [MascotaController::class, 'update']);
    Route::delete('/mascotas/{id}', [MascotaController::class, 'destroy']);

    // Rutas para gestionar Amos
    Route::post('/amos-store', [AmoController::class, 'registro']);
    Route::post('/amos/login', [AmoController::class, 'login']);
    Route::get('/amos', [AmoController::class, 'index']);
    Route::get('/amos/{id}', [AmoController::class, 'show']);
    Route::put('/amos/{id}', [AmoController::class, 'update']);
    Route::delete('/amos/{id}', [AmoController::class, 'destroy']);

    // Rutas para historias clinicas
    Route::get('/historias', [HistoriasController::class, 'index']);
    Route::post('/historias-store', [HistoriasController::class, 'store']);
    Route::get('/historias/{id}', [HistoriasController::class,'show']);
    Route::put('/historias/{id}', [HistoriasController::class, 'update']);
    Route::delete('/historias/{id}', [HistoriasController::class, 'destroy']);

    // Rutas para consultas
    Route::get('/consultas', [ConsultasController::class, 'index']);
    Route::post('/consultas-store', [ConsultasController::class, 'store']);
    Route::get('/consultas/{id}', [ConsultasController::class, 'show']);
    Route::put('/consultas/{id}', [ConsultasController::class, 'update']);
    Route::delete('/consultas/{id}', [ConsultasController::class, 'destroy']);
});


// Ruta para obtener información del usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

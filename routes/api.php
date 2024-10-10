<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;

// Ruta para registrar un nuevo usuario
Route::post('/register', [AuthController::class,'register']);

// Ruta para iniciar sesión
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Agrega aquí otras rutas que necesiten autenticación
    Route::get('/user', [AuthController::class, 'getUser']); // Ejemplo
});


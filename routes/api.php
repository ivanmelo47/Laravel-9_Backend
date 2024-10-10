<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;

// API'S VERSION 1
Route::prefix('v1')->group(function () {
    // Ruta para registrar un nuevo usuario
    Route::post('/register', [AuthController::class, 'register']);

    // Ruta para iniciar sesión
    Route::post('/login', [AuthController::class, 'login']);

    // Rutas protegidas (requieren autenticación)
    Route::middleware('auth:sanctum')->group(function () {

        // Ruta para cerrar SESION
        Route::post('/logout', [AuthController::class, 'logout']);

        // Rutas de administración con prefijo "admin"
        Route::prefix('admin')->group(function () {
            // Ruta para obtener la lista de usuarios
            Route::post('/users', [AdminController::class, 'usuarios']);
        });
    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\LandingPage\HomeController;

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

        // Rutas de administración con prefijo "admin" protegidas por el rol "admin"
        Route::prefix('admin')->middleware('role:admin')->group(function () {
            // Ruta para obtener la lista de usuarios
            Route::post('/users', [AdminController::class, 'usuarios']);
        });

        // Rutas de administración con prefijo "admin" protegidas por el rol "admin"
        Route::prefix('empleado')->middleware('role:empleado')->group(function () {
            // Ruta para obtener la lista de usuarios
            Route::post('/empleados', [AdminController::class, 'usuarios']);
        });
    });

    // Rutas para alimentar el lading page
    Route::prefix('landing-page')->group(function () {
        // Obtener datos personales
        Route::post('/personal-data', [HomeController::class, 'personalDataGet']);
        Route::post('/redes-sociales', [HomeController::class, 'redesSocialesGet']);
        Route::post('/intereses', [HomeController::class, 'interesesGet']);
        Route::post('/skills', [HomeController::class, 'skillsGet']);
        Route::post('/curriculum', [HomeController::class, 'curriculumGet']);
        Route::post('/recibir-mensaje', [HomeController::class, 'recibirMensaje']);
    });

});

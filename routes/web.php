<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Ruta para mostrar el formulario de inicio de sesión
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Ruta para procesar el formulario de inicio de sesión (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Ruta para cerrar sesión (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta para mostrar el formulario de registro (futuro uso)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Ruta para procesar el formulario de registro (futuro uso)
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Rutas protegidas con middleware de autenticación
Route::middleware('auth')->group(function () {
    // Ruta para el dashboard del administrador
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Ruta para actualizar los datos del administrador
    Route::put('/admin/update', [AdminController::class, 'update'])->name('admin.update');

});

// Redirigir a la página de inicio de sesión por defecto
Route::get('/', function () {
    return redirect()->route('login');
});

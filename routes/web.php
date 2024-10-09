<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Ruta para la página de inicio de sesión
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

// Ruta para la página de registro
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

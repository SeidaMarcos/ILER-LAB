<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

// Vista Welcome
Route::view('/', 'welcome')->name('welcome');

// Registro
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware('auth');

// Vistas de estudiantes y profesores pendientes
Route::get('/admin/students', [AdminController::class, 'students'])
    ->name('admin.students')
    ->middleware('auth');
Route::get('/admin/professors', [AdminController::class, 'professors'])
    ->name('admin.professors')
    ->middleware('auth');

// Aprobación y rechazo de registros
Route::get('/admin/approve/{id}', [AdminController::class, 'approveRegistration'])
    ->name('admin.approve')
    ->middleware('auth');
Route::get('/admin/reject/{id}', [AdminController::class, 'rejectRegistration'])
    ->name('admin.reject')
    ->middleware('auth');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboards para otros roles
Route::get('/professor', function () {
    return view('professor.dashboard');
})->name('professor.dashboard')->middleware('auth');

Route::get('/student', function () {
    return view('student.dashboard');
})->name('student.dashboard')->middleware('auth');

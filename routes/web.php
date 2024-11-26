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

// Edit perfil admin
Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.update.profile')->middleware('auth');

Route::put('/admin/student/{id}', [AdminController::class, 'updateStudent'])->name('admin.updateStudent');
Route::delete('/admin/student/{id}', [AdminController::class, 'deleteStudent'])->name('admin.deleteStudent');

Route::put('/admin/update-professor/{id}', [AdminController::class, 'updateProfessor'])->name('admin.updateProfessor');
Route::delete('/admin/delete-professor/{id}', [AdminController::class, 'deleteProfessor'])->name('admin.deleteProfessor');

use App\Http\Controllers\TaskController;

// Panel de tareas
Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin.tasks.panel')->middleware('auth');

// Vista para crear una nueva tarea
Route::get('/admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create')->middleware('auth');

// Guardar una nueva tarea
Route::post('/admin/tasks', [TaskController::class, 'store'])->name('admin.tasks.store')->middleware('auth');

// Eliminar una tarea
Route::delete('/admin/tasks/{id}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy')->middleware('auth');

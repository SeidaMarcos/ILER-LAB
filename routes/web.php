<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Rutas del Administrador
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Gestión de registros pendientes
        Route::post('/registrations/{id}/approve', [AdminController::class, 'approveRegistration'])->name('registrations.approve');
        Route::post('/registrations/{id}/reject', [AdminController::class, 'rejectRegistration'])->name('registrations.reject');

        // Gestión de usuarios
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('updateUser');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

        // Perfil del administrador
        Route::put('/update', [AdminController::class, 'update'])->name('update');
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas de Profesores
    |--------------------------------------------------------------------------
    */
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::put('/updateProfile', [TeacherController::class, 'updateProfile'])->name('updateProfile');
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas de Estudiantes
    |--------------------------------------------------------------------------
    */
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::put('/profile/update', [StudentController::class, 'updateProfile'])->name('updateProfile');
        Route::get('/tasks/{task}', [StudentController::class, 'showTask'])->name('tasks.show');
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas de Tareas
    |--------------------------------------------------------------------------
    */
    Route::resource('tasks', TaskController::class);
});

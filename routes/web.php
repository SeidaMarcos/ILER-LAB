<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TaskController;



// Ruta para la página de bienvenida (welcome)
Route::get('/', function () {
    return view('welcome'); // Cambia la ruta inicial a la vista welcome
})->name('welcome');

// Ruta para mostrar el formulario de inicio de sesión
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Ruta para procesar el formulario de inicio de sesión (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Ruta para cerrar sesión (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta para mostrar el formulario de registro
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Ruta para procesar el formulario de registro
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Rutas protegidas con middleware de autenticación
Route::middleware(['auth'])->group(function () {
    // Ruta para el dashboard del administrador
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::put('/teacher/updateProfile', [TeacherController::class, 'updateProfile'])->name('teacher.updateProfile');




    Route::middleware(['auth'])->group(function () {
        // Ruta para el dashboard del estudiante
        Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

        // Ruta para actualizar el perfil del estudiante
        Route::put('/student/profile/update', [StudentController::class, 'updateProfile'])->name('student.updateProfile');
    });



    // Ruta para actualizar los datos del administrador
    Route::put('/admin/update', [AdminController::class, 'update'])->name('admin.update');

    // Ruta para aprobar un registro pendiente
    Route::post('/admin/registrations/{id}/approve', [AdminController::class, 'approveRegistration'])->name('admin.registrations.approve');

    // Ruta para rechazar un registro pendiente
    Route::post('/admin/registrations/{id}/reject', [AdminController::class, 'rejectRegistration'])->name('admin.registrations.reject');

    // Ruta para actualizar un usuario específico
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');

    // Ruta para eliminar usuario
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
});
;
Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

Route::get('/student/tasks/{task}', [StudentController::class, 'showTask'])->name('student.tasks.show');

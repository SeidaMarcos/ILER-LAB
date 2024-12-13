<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;

// Rutas públicas
Route::view('/', 'welcome')->name('welcome');

// Registro
Route::prefix('register')->group(function () {
    Route::get('/', [RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/', [RegisterController::class, 'register'])->name('register');
});

// Login y Logout
Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('login.submit');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas del administrador (Protegidas con Middleware Auth)
Route::middleware('auth')->prefix('admin')->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Gestión de estudiantes
    Route::prefix('students')->group(function () {
        Route::get('/', [AdminController::class, 'students'])->name('admin.students');
        Route::put('/{id}', [AdminController::class, 'updateStudent'])->name('admin.updateStudent');
        Route::delete('/{id}', [AdminController::class, 'deleteStudent'])->name('admin.deleteStudent');
    });

    // Gestión de profesores
    Route::prefix('professors')->group(function () {
        Route::get('/', [AdminController::class, 'professors'])->name('admin.professors');
        Route::put('/{id}', [AdminController::class, 'updateProfessor'])->name('admin.updateProfessor');
        Route::delete('/{id}', [AdminController::class, 'deleteProfessor'])->name('admin.deleteProfessor');
    });

    // Aprobación y rechazo de registros pendientes
    Route::get('/approve/{id}', [AdminController::class, 'approveRegistration'])->name('admin.approve');
    Route::get('/reject/{id}', [AdminController::class, 'rejectRegistration'])->name('admin.reject');

    // Actualizar perfil del administrador
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.update.profile');

    // Gestión de tareas
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('admin.tasks.panel');
        Route::get('/create', [TaskController::class, 'create'])->name('admin.tasks.create');
        Route::post('/', [TaskController::class, 'store'])->name('admin.tasks.store');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');
        Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
        Route::put('/{id}', [TaskController::class, 'update'])->name('admin.tasks.update');
    });
});

// Rutas del estudiante
Route::middleware('auth')->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/task/{id}', [StudentController::class, 'taskDetails'])->name('student.details');
    Route::post('/tasks/{id}/upload', [StudentController::class, 'uploadTask'])->name('student.tasks.upload');
});

// Rutas del profesor
Route::middleware('auth')->prefix('professor')->group(function () {
    Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('professor.dashboard');
    Route::get('/tasks/panel', [ProfessorController::class, 'panelTasks'])->name('professor.tasks.panel');
    Route::get('/tasks/completed', [ProfessorController::class, 'completedTasks'])->name('professor.tasks.completed');
    Route::get('/tasks/{id}', [ProfessorController::class, 'taskDetails'])->name('professor.task.details');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('professor.tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('professor.tasks.store');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('professor.tasks.edit');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('professor.tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('professor.tasks.destroy');
});

use App\Http\Controllers\InventoryController;

Route::middleware(['auth'])->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/products', [InventoryController::class, 'storeProduct'])->name('inventory.store.product');
    Route::post('/inventory/machines', [InventoryController::class, 'storeMachine'])->name('inventory.store.machine');
    Route::post('/inventory/tools', [InventoryController::class, 'storeTool'])->name('inventory.store.tool');
});



// Productos
Route::post('/inventory/products', [InventoryController::class, 'storeProduct'])->name('inventory.store.product');
Route::put('/inventory/products/{id}', [InventoryController::class, 'updateProduct'])->name('inventory.update.product');
Route::delete('/inventory/products/{id}', [InventoryController::class, 'destroyProduct'])->name('inventory.destroy.product');

// Máquinas
Route::post('/inventory/machines', [InventoryController::class, 'storeMachine'])->name('inventory.store.machine');
Route::put('/inventory/machines/{id}', [InventoryController::class, 'updateMachine'])->name('inventory.update.machine');
Route::delete('/inventory/machines/{id}', [InventoryController::class, 'destroyMachine'])->name('inventory.destroy.machine');

// Herramientas
Route::post('/inventory/tools', [InventoryController::class, 'storeTool'])->name('inventory.store.tool');
Route::put('/inventory/tools/{id}', [InventoryController::class, 'updateTool'])->name('inventory.update.tool');
Route::delete('/inventory/tools/{id}', [InventoryController::class, 'destroyTool'])->name('inventory.destroy.tool');

// Página principal del inventario
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

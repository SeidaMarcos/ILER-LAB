@extends('layouts.adminLayout')

@section('title', 'Panel de Tareas')

@section('content')

<a href="{{ route('admin.dashboard') }}" class="btn btn-light">
    <i class="fas fa-arrow-left"></i>
</a>

<div class="container mt-5">
    <h1 class="text-center mb-4 text-dark">Panel de Tareas</h1>

    @if($tasks->isEmpty())
        <!-- No hay tareas -->
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white" style="background-color: #14b8a6;">
                <h2 class="mb-0">Tareas</h2>
            </div>
            <div class="card-body">
                <p class="text-center text-muted">No hay tareas creadas.</p>
                <!-- Botón para crear nueva tarea -->
                <div class="text-end">
                    <a href="{{ route('admin.tasks.create') }}"
                        class="d-flex align-items-center justify-content-center btn-create-task"
                        style="background-color: #14b8a6; color: white; width: 50px; height: 50px; border-radius: 50%; text-decoration: none; border: none; transition: transform 0.2s ease;">
                        <i class="fas fa-plus" style="font-size: 1.2rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Tareas Actuales -->
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white d-flex align-items-center justify-content-between"
                style="background-color: #14b8a6;">
                <h2 class="mb-0">Tareas</h2>
                <!-- Botón para crear nueva tarea -->
                <a href="{{ route('admin.tasks.create') }}"
                    class="d-flex align-items-center justify-content-center btn-create-task"
                    style="background-color: #ffffff; color: #14b8a6; width: 50px; height: 50px; border-radius: 50%; text-decoration: none; border: none; transition: transform 0.2s ease; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);">
                    <i class="fas fa-plus" style="font-size: 1.2rem;"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Prioridad</th>
                                <th>Fecha de Entrega</th>
                                <th>Archivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                            <tr>
                                                <td class="text-center">{{ $task->id }}</td>
                                                <td class="text-center">{{ $task->name }}</td>
                                                <td class="text-center">{{ $task->description }}</td>
                                                <td class="text-center">
                                                    <span class="badge text-white" style="background-color: 
                                        {{ $task->priority === 'baja' ? '#28a745' :
                                ($task->priority === 'media' ? '#ffc107' :
                                    ($task->priority === 'alta' ? '#fd7e14' :
                                        ($task->priority === 'urgente' ? '#dc3545' : '#28a745'))) }}">
                                                        {{ ucfirst($task->priority) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">{{ $task->date }}</td>
                                                <td class="text-center">
                                                    @if($task->pdf)
                                                        <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank"
                                                            class="btn btn-outline-info btn-sm">
                                                            Ver PDF
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No disponible</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Botón Editar -->
                                                    <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                                        class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <!-- Botón Eliminar -->
                                                    <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

<style>
    .btn-create-task:hover {
        transform: scale(1.1);
        background-color: #119b90;
    }
</style>
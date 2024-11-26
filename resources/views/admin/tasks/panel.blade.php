@extends('layouts.adminLayout')

@section('title', 'Panel de Tareas')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Panel de Tareas</h1>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Botón para crear nueva tarea -->
    <div class="mb-4 text-end">
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear Nueva Tarea
        </a>
    </div>

    <!-- Tabla de tareas -->
    @if($tasks->isEmpty())
        <p class="text-center">No hay tareas creadas.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Prioridad</th>
                    <th>Progreso</th>
                    <th>Fecha de Entrega</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ ucfirst($task->priority) }}</td>
                        <td>{{ $task->progress }}%</td>
                        <td>{{ $task->date }}</td>
                        <td>
                            @if($task->pdf)
                                <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank">Ver PDF</a>
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

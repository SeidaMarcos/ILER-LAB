@extends('layouts.tasksLayout')

@section('title', 'Lista de Tareas')

@section('content')
<h1 class="text-center">Lista de Tareas</h1>
<a href="{{ route('tasks.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus"></i></a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No hay tareas disponibles.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

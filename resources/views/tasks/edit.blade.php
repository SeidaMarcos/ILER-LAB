@extends('layouts.tasksLayout')

@section('title', 'Editar Tarea')

@section('content')
<h1 class="text-center">Editar Tarea</h1>
<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Nombre de la Tarea</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $task->name }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control">{{ $task->description }}</textarea>
    </div>
    <div class="mb-3">
        <label for="priority" class="form-label">Prioridad</label>
        <select name="priority" id="priority" class="form-select" required>
            <option value="baja" {{ $task->priority == 'baja' ? 'selected' : '' }}>Baja</option>
            <option value="media" {{ $task->priority == 'media' ? 'selected' : '' }}>Media</option>
            <option value="alta" {{ $task->priority == 'alta' ? 'selected' : '' }}>Alta</option>
            <option value="urgente" {{ $task->priority == 'urgente' ? 'selected' : '' }}>Urgente</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="progress" class="form-label">Progreso</label>
        <select name="progress" id="progress" class="form-select" required>
            <option value="0" {{ $task->progress == '0' ? 'selected' : '' }}>0</option>
            <option value="25" {{ $task->progress == '25' ? 'selected' : '' }}>25</option>
            <option value="50" {{ $task->progress == '50' ? 'selected' : '' }}>50</option>
            <option value="75" {{ $task->progress == '75' ? 'selected' : '' }}>75</option>
            <option value="100" {{ $task->progress == '100' ? 'selected' : '' }}>100</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection

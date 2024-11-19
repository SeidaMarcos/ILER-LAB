@extends('layouts.tasksLayout')

@section('title', 'Editar Tarea')

@section('content')
<h1 class="text-center">Editar Tarea</h1>
<form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
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
        <label for="due_date" class="form-label">Fecha de Entrega</label>
        <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $task->due_date }}">
    </div>
    <div class="mb-3">
        <label for="pdf" class="form-label">PDF Actual</label>
        @if ($task->pdf_path) <!-- Asegúrate de que este sea el nombre correcto del campo en tu base de datos -->
            <p>
                <a href="{{ Storage::url($task->pdf_path) }}" target="_blank" class="btn btn-warning">
                    <i class="fas fa-eye"></i> </a>
            </p>
        @else
            <p>No hay un PDF asignado.</p>
        @endif
        <label for="pdf" class="form-label">Cambiar PDF</label>
        <input type="file" name="pdf" id="pdf" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i>
    </button>
</form>
@endsection
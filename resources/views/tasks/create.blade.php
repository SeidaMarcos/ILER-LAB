@extends('layouts.tasksLayout')

@section('title', 'Crear Tarea')

@section('content')
<h1 class="text-center">Crear Tarea</h1>
<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name_create" class="form-label">Nombre de la Tarea</label>
        <input type="text" name="name" id="name_create" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description_create" class="form-label">Descripción</label>
        <textarea name="description" id="description_create" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label for="due_date_create" class="form-label">Fecha de Entrega</label>
        <input type="date" name="due_date" id="due_date_create" class="form-control">
    </div>
    <div class="mb-3">
        <label for="priority_create" class="form-label">Prioridad</label>
        <select name="priority" id="priority_create" class="form-select" required>
            <option value="baja">Baja</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
            <option value="urgente">Urgente</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="progress_create" class="form-label">Progreso</label>
        <select name="progress" id="progress_create" class="form-select" required>
            <option value="0">0</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">
        <i class="fas fa-check"></i>
    </button>
</form>
@endsection
@extends('layouts.tasksLayout')

@section('title', 'Crear Tarea')

@section('content')
<h1 class="text-center">Crear Tarea</h1>
<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nombre de la Tarea</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label for="priority" class="form-label">Prioridad</label>
        <select name="priority" id="priority" class="form-select" required>
            <option value="baja">Baja</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
            <option value="urgente">Urgente</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection

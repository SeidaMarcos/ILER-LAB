@extends('layouts.adminLayout')

@section('title', 'Editar Tarea')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Editar Tarea</h1>

    <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="description">Descripción</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $task->description }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="priority">Prioridad</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="baja" {{ $task->priority == 'baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ $task->priority == 'media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ $task->priority == 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="urgente" {{ $task->priority == 'urgente' ? 'selected' : '' }}>Urgente</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="progress">Progreso</label>
            <select name="progress" id="progress" class="form-control" required>
                <option value="0" {{ $task->progress == 0 ? 'selected' : '' }}>0%</option>
                <option value="25" {{ $task->progress == 25 ? 'selected' : '' }}>25%</option>
                <option value="50" {{ $task->progress == 50 ? 'selected' : '' }}>50%</option>
                <option value="75" {{ $task->progress == 75 ? 'selected' : '' }}>75%</option>
                <option value="100" {{ $task->progress == 100 ? 'selected' : '' }}>100%</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="date">Fecha de Entrega</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $task->date }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="pdf">Archivo PDF (opcional)</label>
            <input type="file" name="pdf" id="pdf" class="form-control">
            @if ($task->pdf)
                <p class="mt-2">Archivo actual: <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank">Ver PDF</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
    </form>
</div>
@endsection
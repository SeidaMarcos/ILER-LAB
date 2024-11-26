@extends('layouts.adminLayout')

@section('title', 'Crear Nueva Tarea')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Crear Nueva Tarea</h1>

    <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="description">Descripción</label>
            <input type="text" name="description" id="description" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="priority">Prioridad</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="progress">Progreso</label>
            <select name="progress" id="progress" class="form-control" required>
                <option value="0">0%</option>
                <option value="25">25%</option>
                <option value="50">50%</option>
                <option value="75">75%</option>
                <option value="100">100%</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="date">Fecha de Entrega</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="pdf">Archivo PDF (opcional)</label>
            <input type="file" name="pdf" id="pdf" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Crear Tarea</button>
    </form>
</div>
@endsection

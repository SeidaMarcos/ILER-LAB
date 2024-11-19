@extends('layouts.tasksLayout')

@section('title', 'Crear Tarea')

@section('content')
<h1 class="text-center">Crear Tarea</h1>
<!-- enctype="multipart/form-data sin esto no procesa un archivo pdf -->
<form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
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
    <div class="mb-3">
        <label for="progress" class="form-label">Progreso</label>
        <select name="progress" id="progress" class="form-select" required>
            <option value="0">0</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="due_date" class="form-label">Fecha de Entrega</label>
        <input type="date" name="due_date" id="due_date" class="form-control">
    </div>
    <div class="mb-3">
        <label for="pdf" class="form-label">Archivo PDF</label>
        <input type="file" name="pdf" id="pdf" class="form-control" accept=".pdf">
        <button type="button" id="remove-pdf" class="btn btn-danger mt-2" style="display: none;">Quitar PDF</button>
    </div>
    <button type="submit" class="btn btn-success">
        <i class="fas fa-plus"></i>
    </button>
</form>

<script>
    // Referencia al campo de archivo y botón de eliminar
    const pdfInput = document.getElementById('pdf');
    const removeButton = document.getElementById('remove-pdf');

    // Mostrar el botón de eliminar si hay un archivo seleccionado
    pdfInput.addEventListener('change', function () {
        if (pdfInput.files.length > 0) {
            removeButton.style.display = 'inline-block';
        } else {
            removeButton.style.display = 'none';
        }
    });

    // Eliminar el archivo seleccionado
    removeButton.addEventListener('click', function () {
        pdfInput.value = ''; // Limpiar el valor del campo
        removeButton.style.display = 'none'; // Ocultar el botón de eliminar
    });
</script>
@endsection

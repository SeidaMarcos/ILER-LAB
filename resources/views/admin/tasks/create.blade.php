@extends('layouts.adminLayout')

@section('title', 'Crear Nueva Tarea')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Crear Nueva Tarea</h1>



    <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="description">Descripción</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}"
                required>
        </div>

        <div class="form-group mb-3">
            <label for="priority">Prioridad</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="baja" {{ old('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('priority') == 'media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="urgente" {{ old('priority') == 'urgente' ? 'selected' : '' }}>Urgente</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="progress">Progreso</label>
            <select name="progress" id="progress" class="form-control" required>
                <option value="0" {{ old('progress') == '0' ? 'selected' : '' }}>0%</option>
                <option value="25" {{ old('progress') == '25' ? 'selected' : '' }}>25%</option>
                <option value="50" {{ old('progress') == '50' ? 'selected' : '' }}>50%</option>
                <option value="75" {{ old('progress') == '75' ? 'selected' : '' }}>75%</option>
                <option value="100" {{ old('progress') == '100' ? 'selected' : '' }}>100%</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="date">Fecha de Entrega</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="pdf">Archivo PDF (opcional)</label>
            <div class="input-group">
                <input type="file" name="pdf" id="pdf" class="form-control">
                <button type="button" id="clearPdf" class="btn btn-danger fas fa-trash-alt"></button>
            </div>
            @error('pdf')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-custom-shared btn-login-custom"><i class="fas fa-plus"></i></button>
    </form>
</div>

<script>
    document.getElementById('clearPdf').addEventListener('click', function () {
        document.getElementById('pdf').value = '';
    });
</script>
@endsection
@extends('layouts.adminLayout')

@section('title', 'Crear Nueva Tarea')

@section('content')

<a href="{{ route('admin.tasks.panel') }}" class="btn btn-light">
    <i class="fas fa-arrow-left"></i>
</a>

<div class="container mt-5 mb-5">
    <h1 class="text-center mb-4">Crear Nueva Tarea</h1>
    <!-- Formulario de filtrado -->
    <form action="{{ route('admin.tasks.create') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Buscar por Nombre"
                    value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <input type="email" name="email" class="form-control" placeholder="Buscar por Correo"
                    value="{{ request('email') }}">
            </div>
            <div class="col-md-2">
                <select name="ciclo" class="form-control">
                    <option value="">Filtrar Ciclo (Todos)</option>
                    <option value="anatomia" {{ request('ciclo') == 'anatomia' ? 'selected' : '' }}>Anatomía</option>
                    <option value="laboratorio" {{ request('ciclo') == 'laboratorio' ? 'selected' : '' }}>Laboratorio
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="curso" class="form-control">
                    <option value="">Filtrar Curso (Todos)</option>
                    <option value="1º" {{ request('curso') == '1º' ? 'selected' : '' }}>1º</option>
                    <option value="2º" {{ request('curso') == '2º' ? 'selected' : '' }}>2º</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-block btn-custom-shared btn-login-custom"><i
                        class="fas fa-search"></i></button>
            </div>
        </div>
    </form>

    <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

         <!-- Checkbox "Seleccionar todos" -->
         <div class="form-check">
            <input type="checkbox" id="selectAll" class="form-check-input">
            <label for="selectAll" class="form-check-label">Seleccionar Todos</label>
        </div>

        <!-- Checkboxes para estudiantes -->
        @foreach ($students as $student)
            <div class="form-check">
                <input type="checkbox" name="students[]" value="{{ $student->student->id }}"
                    id="student-{{ $student->student->id }}" class="form-check-input">

                <label for="student-{{ $student->student->id }}" class="form-check-label">
                    {{ $student->name }} ({{ $student->email }})
                </label>
                @error('students')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @endforeach

        <div class="form-group mb-3 mt-5">
            <label for="name">Nombre de la Tarea</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="description">Descripción</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}"
                required>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
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
            <label for="date">Fecha de Entrega</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
            @error('date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
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

        <!-- Selección de herramientas, máquinas y productos -->
        <h4 class="mt-5">Recursos Requeridos</h4>

        <!-- Herramientas -->
        <h5>Herramientas</h5>
        @foreach ($tools as $tool)
            <div class="form-check">
                <input type="checkbox" name="tools[]" value="{{ $tool->id }}" id="tool-{{ $tool->id }}" class="form-check-input">
                <label for="tool-{{ $tool->id }}" class="form-check-label">
                    {{ $tool->name }} ({{ $tool->material }}) - Stock: {{ $tool->stock }}
                </label>
            </div>
        @endforeach

        <!-- Máquinas -->
        <h5 class="mt-3">Máquinas</h5>
        @foreach ($machines as $machine)
            <div class="form-check">
                <input type="checkbox" name="machines[]" value="{{ $machine->id }}" id="machine-{{ $machine->id }}" class="form-check-input">
                <label for="machine-{{ $machine->id }}" class="form-check-label">
                    {{ $machine->name }} - Ubicación: {{ $machine->location }}
                </label>
            </div>
        @endforeach

        <!-- Productos -->
        <h5 class="mt-3">Productos</h5>
        @foreach ($products as $product)
            <div class="form-check">
                <input type="checkbox" name="products[]" value="{{ $product->id }}" id="product-{{ $product->id }}" class="form-check-input">
                <label for="product-{{ $product->id }}" class="form-check-label">
                    {{ $product->name }} - Ubicación: {{ $product->location }} - Densidad: {{ $product->density }} g/ml
                </label>
            </div>
        @endforeach

        <button type="submit" class="btn-custom-shared btn-login-custom mb-5 mt-5"><i class="fas fa-plus"></i></button>
    </form>
</div>

<script>
        const clearPdfButton = document.getElementById('clearPdf');
        if (clearPdfButton) {
            clearPdfButton.addEventListener('click', function () {
                const pdfInput = document.getElementById('pdf');
                if (pdfInput) {
                    pdfInput.value = ''; // Limpia el valor del campo
                }
            });
        }


    document.addEventListener('DOMContentLoaded', function () {
        // Comprobar que el checkbox "selectAll" existe
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            // Añadir evento de clic al checkbox "Seleccionar todos"
            selectAllCheckbox.addEventListener('click', function () {
                const checkboxes = document.querySelectorAll('input[name="students[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked; // Sincroniza el estado
                });
            });
        }
    });

</script>

@endsection
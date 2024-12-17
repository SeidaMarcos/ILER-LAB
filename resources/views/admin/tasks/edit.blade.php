@extends('layouts.adminLayout')

@section('title', 'Editar Tarea')

@section('content')

<a href="{{ route('admin.tasks.panel') }}" class="btn btn-light">
    <i class="fas fa-arrow-left"></i>
</a>

<div class="container mt-5 mb-5">
    <h1 class="text-center mb-4">Editar Tarea</h1>
    <!-- Filtros -->
    <form action="{{ route('admin.tasks.edit', $task->id) }}" method="GET" class="mb-4">
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
                    <option value="">Seleccionar Ciclo</option>
                    <option value="anatomia" {{ request('ciclo') == 'anatomia' ? 'selected' : '' }}>Anatomía</option>
                    <option value="laboratorio" {{ request('ciclo') == 'laboratorio' ? 'selected' : '' }}>Laboratorio
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="curso" class="form-control">
                    <option value="">Seleccionar Curso</option>
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
    <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Lista de estudiantes -->
        <div class="form-group mb-5">
            <label for="students">Estudiantes</label>
            <div class="form-check">
                <input type="checkbox" id="selectAll" class="form-check-input">
                <label for="selectAll" class="form-check-label">Seleccionar Todos</label>
            </div>

            @foreach ($students as $student)
                <div class="form-check">
                    <input type="checkbox" name="students[]" value="{{ $student->student->id }}"
                        id="student-{{ $student->student->id }}" class="form-check-input" {{ $task->students->contains('id', $student->student->id) ? 'checked' : '' }}>
                    <label for="student-{{ $student->student->id }}" class="form-check-label">
                        {{ $student->name }} ({{ $student->email }})
                    </label>
                </div>
            @endforeach
        </div>

        <div class="form-group mb-3">
            <label for="name">Nombre de la Tarea</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $task->name }}" required>
        </div>


        <div class="form-group mb-3">
            <label for="description">Descripción</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $task->description }}"
                required>
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
            <label for="date">Fecha de Entrega</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $task->date }}" required>
            @error('date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-5">
            <label for="pdf">Reemplaza/Añade PDF (opcional)</label>
            <input type="file" name="pdf" id="pdf" class="form-control">

            @if ($task->pdf)
                <div class="form-check mt-2">
                    <input type="checkbox" name="remove_pdf" id="removePdf" value="1" class="form-check-input">
                    <label for="removePdf" class="form-check-label">Guardar sin archivo PDF</label>
                </div>
                <p class="mt-2">Archivo actual:
                    <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank">Ver PDF</a>
                </p>
            @endif

            @error('pdf')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <!-- Selección de herramientas, máquinas y productos -->
        <h4 class="mt-4">Recursos Requeridos</h4>

        <!-- Herramientas -->
        <h5>Herramientas</h5>
        @foreach ($tools as $tool)
            <div class="form-check">
                <input type="checkbox" name="tools[]" value="{{ $tool->id }}" id="tool-{{ $tool->id }}"
                    class="form-check-input" {{ $task->tools->contains($tool->id) ? 'checked' : '' }}>
                <label for="tool-{{ $tool->id }}" class="form-check-label">
                    {{ $tool->name }} ({{ $tool->material }}) - Stock: {{ $tool->stock }}
                </label>
            </div>
        @endforeach

        <!-- Máquinas -->
        <h5 class="mt-3">Máquinas</h5>
        @foreach ($machines as $machine)
            <div class="form-check">
                <input type="checkbox" name="machines[]" value="{{ $machine->id }}" id="machine-{{ $machine->id }}"
                    class="form-check-input" {{ $task->machines->contains($machine->id) ? 'checked' : '' }}>
                <label for="machine-{{ $machine->id }}" class="form-check-label">
                    {{ $machine->name }} - Ubicación: {{ $machine->location }}
                </label>
            </div>
        @endforeach

        <!-- Productos -->
        <h5 class="mt-3">Productos</h5>
        @foreach ($products as $product)
            <div class="form-check">
                <input type="checkbox" name="products[]" value="{{ $product->id }}" id="product-{{ $product->id }}"
                    class="form-check-input" {{ $task->products->contains($product->id) ? 'checked' : '' }}>
                <label for="product-{{ $product->id }}" class="form-check-label">
                    {{ $product->name }} - Ubicación: {{ $product->location }} - Densidad: {{ $product->density }} g/ml
                </label>
            </div>
        @endforeach

        <button type="submit" class="btn-custom-shared btn-login-custom mt-5 mb-5"><i class="fas fa-save"></i></button>

    </form>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('click', function () {
                const checkboxes = document.querySelectorAll('input[name="students[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        }
    });
</script>
@endsection
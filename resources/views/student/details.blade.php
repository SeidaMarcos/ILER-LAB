@extends('layouts.adminLayout')

@section('title', 'Detalles de Tarea')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Detalles de Tarea</h1>

    <div class="card shadow-lg border-0">
        <div class="card-body">

            <!-- Nombre de la Tarea -->
            <h5 class="card-title text-white" style="background-color: #13a292; padding: 10px; border-radius: 5px;">
                {{ $task->name }}
            </h5>

            <!-- Detalles generales -->
            <div class="mb-4">
                <h6><strong>Descripción:</strong></h6>
                <p>{{ $task->description }}</p>

                <h6><strong>Prioridad:</strong></h6>
                <p>
                    <span class="badge text-white" style="background-color: 
                        {{ $task->priority === 'baja' ? '#28a745' :
    ($task->priority === 'media' ? '#ffc107' :
        ($task->priority === 'alta' ? '#fd7e14' : '#dc3545')) }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                </p>

                <h6><strong>Fecha de Entrega:</strong></h6>
                <p>{{ \Carbon\Carbon::parse($task->date)->format('d/m/Y') }}</p>
            </div>

            <!-- Archivo adjunto de la Tarea -->
            <div class="mb-4">
                <h6><strong>Archivo:</strong></h6>
                @if ($task->pdf)
                    <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Ver/Descargar PDF
                    </a>
                @else
                    <p>Sin archivo adjunto</p>
                @endif
            </div>

            <!-- Productos utilizados (si ya se entregó la tarea) -->
            @if ($task->student_pdf)
                <div class="mb-4">
                    <h6><strong>Productos Última Entrega:</strong></h6>
                    @if ($task->products && $task->products->isNotEmpty())
                        <ul class="list-group">
                            @foreach ($task->products as $product)
                                <li class="list-group-item">
                                    <strong>Nombre:</strong> {{ $product->name }}<br>
                                    <strong>Densidad:</strong> {{ $product->density }} g/ml<br>
                                    <strong>Ubicación:</strong> {{ $product->location }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No se registraron productos para esta tarea.</p>
                    @endif
                </div>
            @endif

            <!-- Formulario para entregar la tarea -->
            <form action="{{ route('student.tasks.upload', $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Subir archivo PDF -->
                <div class="mb-4">
                    <h6><strong>Entregar Archivo (PDF):</strong></h6>
                    <input type="file" name="student_pdf" id="student_pdf" class="form-control" required>
                    @error('student_pdf')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Enlace al último archivo entregado -->
                @if ($task->student_pdf)
                    <p class="text-success mt-3">
                        <i class="fas fa-check-circle"></i> Tarea ya entregada.
                        <a href="{{ asset('storage/' . $task->student_pdf) }}" target="_blank" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Ver última entrega
                        </a>
                    </p>
                @endif

                <!-- Productos utilizados -->
                <h6 class="mt-4"><strong>Productos Utilizados:</strong></h6>
                <div id="products-container" class="mb-4">
                    <!-- Contenedor para productos -->
                </div>

                <!-- Botones para agregar productos y entregar tarea -->
                <div class="d-flex justify-content-end">
                    <button type="button" id="add-product" class="btn btn-secondary me-2">
                        <i class="fas fa-plus"></i> Añadir Producto
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> {{ $task->student_pdf ? 'Entregar de Nuevo' : 'Entregar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let productIndex = 0;

    // Funcionalidad para agregar productos dinámicamente
    document.getElementById('add-product').addEventListener('click', () => {
        const container = document.getElementById('products-container');

        const newProduct = document.createElement('div');
        newProduct.classList.add('product-item', 'mb-3');

        newProduct.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 me-3">
                    <label>Nombre del Producto:</label>
                    <input type="text" name="products[${productIndex}][name]" class="form-control mb-2" required>

                    <label>Densidad:</label>
                    <input type="number" step="0.01" name="products[${productIndex}][density]" class="form-control mb-2" required>

                    <label>Ubicación:</label>
                    <input type="text" name="products[${productIndex}][location]" class="form-control mb-2" required>
                </div>
                <button type="button" class="btn btn-danger align-self-start" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-trash-alt"></i> 
                </button>
            </div>
            <hr>
        `;

        container.appendChild(newProduct);
        productIndex++;
    });
</script>
@endsection
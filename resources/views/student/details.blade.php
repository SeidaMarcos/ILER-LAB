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

            <!-- Recursos requeridos -->
            <h4 class="mt-4">Recursos Requeridos</h4>

            <!-- Herramientas -->
            @if ($task->tools->isNotEmpty())
                <h5>Herramientas:</h5>
                <ul>
                    @foreach ($task->tools as $tool)
                        <li>{{ $tool->name }} ({{ $tool->material }}) - Stock: {{ $tool->stock }}</li>
                    @endforeach
                </ul>
            @else
                <p>No se requieren herramientas.</p>
            @endif

            <!-- Máquinas -->
            @if ($task->machines->isNotEmpty())
                <h5>Máquinas:</h5>
                <ul>
                    @foreach ($task->machines as $machine)
                        <li>{{ $machine->name }} - Ubicación: {{ $machine->location }}</li>
                    @endforeach
                </ul>
            @else
                <p>No se requieren máquinas.</p>
            @endif

            <!-- Productos -->
            @if ($task->products->isNotEmpty())
                <h5>Productos:</h5>
                <ul>
                    @foreach ($task->products as $product)
                        <li>{{ $product->name }} - Ubicación: {{ $product->location }} - Densidad: {{ $product->density }} g/ml</li>
                    @endforeach
                </ul>
            @else
                <p>No se requieren productos.</p>
            @endif

            <!-- Formulario para entregar la tarea -->
            <form action="{{ route('student.tasks.upload', $task->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <h5>Entrega de Tarea</h5>
                <div class="mb-3">
                    <input type="file" name="student_pdf" id="student_pdf" class="form-control" required>
                    @error('student_pdf')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-upload"></i> {{ $task->student_pdf ? 'Entregar de Nuevo' : 'Entregar' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

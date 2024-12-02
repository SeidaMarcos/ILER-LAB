@extends('layouts.adminLayout')

@section('title', 'Detalles de Tarea')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Detalles de Tarea</h1>
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h5 class="card-title text-white" style="background-color: #13a292; padding: 10px; border-radius: 5px;">
                Tarea #{{ $task->id }}
            </h5>
            <p><strong>Descripción:</strong> {{ $task->description }}</p>
            <p><strong>Prioridad:</strong> 
                <span class="badge text-white" style="background-color: 
                    {{ $task->priority === 'baja' ? '#28a745' : 
                       ($task->priority === 'media' ? '#ffc107' : 
                       ($task->priority === 'alta' ? '#fd7e14' : '#dc3545')) }}">
                    {{ ucfirst($task->priority) }}
                </span>
            </p>
            <p><strong>Progreso:</strong> {{ $task->progress }}%</p>
            <p><strong>Fecha de Entrega:</strong> {{ \Carbon\Carbon::parse($task->date)->format('d/m/Y') }}</p>
            @if ($task->pdf)
                <p><strong>Archivo:</strong> <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank">Ver/Descargar PDF</a></p>
            @else
                <p><strong>Archivo:</strong> Sin archivo adjunto</p>
            @endif

            <form action="{{ route('student.tasks.upload', $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="student_pdf" class="form-label">Entregar Archivo (PDF)</label>
                    <input type="file" name="student_pdf" id="student_pdf" class="form-control" required>
                    @error('student_pdf')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @if ($task->student_pdf)
                <p class="text-success mt-3"><i class="fas fa-check-circle"></i> Tarea ya entregada.</p>
                <a href="{{ asset('storage/' . $task->student_pdf) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Ver Última Entrega 
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-upload"></i> {{ $task->student_pdf ? 'Entregar de Nuevo' : 'Entregar' }}
                </button>
            @endif
            </form>

        </div>
    </div>
</div>
@endsection

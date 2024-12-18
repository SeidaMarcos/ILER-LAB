@extends('layouts.adminLayout')

@section('title', 'Detalles de la Tarea')

@section('content')

<a href="{{ route('professor.tasks.completed') }}" class="btn btn-light mb-3">
    <i class="fas fa-arrow-left"></i>
</a>

<div class="container mt-5">
    <h1 class="text-center mb-4">
        Detalles: <span class="text-green">{{ $task->name }}</span>
    </h1>

    <!-- Información general de la tarea -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-3"><strong>Descripción:</strong></h5>
            <p>{{ $task->description }}</p>

            <h5 class="mb-3"><strong>Prioridad:</strong></h5>
            <p>
                <span class="badge text-white" style="background-color: 
                    {{ $task->priority === 'baja' ? '#28a745' :
    ($task->priority === 'media' ? '#ffc107' :
        ($task->priority === 'alta' ? '#fd7e14' : '#dc3545')) }};">
                    {{ ucfirst($task->priority) }}
                </span>
            </p>

            <h5 class="mb-3"><strong>Fecha de Entrega:</strong></h5>
            <p>{{ \Carbon\Carbon::parse($task->date)->format('d/m/Y') }}</p>

            <h5 class="mb-3"><strong>Archivo Adjunto:</strong></h5>
            @if ($task->pdf)
                <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Ver/Descargar PDF
                </a>
            @else
                <span class="text-muted">No hay archivo adjunto para esta tarea.</span>
            @endif
        </div>
    </div>

    <!-- Tabla de entregas -->
    @if ($task->students->isEmpty())
        <div class="alert alert-info text-center">
            <p class="mb-0">No hay estudiantes asociados a esta tarea.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-primary text-center">
                    <tr>
                        <th class="text-start">Nombre del Estudiante</th>
                        <th>Estado de la Entrega</th>
                        <th>Archivo Entregado</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($task->students as $student)
    @php
        // Obtener la última entrega del estudiante
        $submission = $student->submissions()
            ->where('task_id', $task->id)
            ->latest('created_at') // Ordenar por fecha de creación descendente
            ->first();

        $fechaEntrega = \Carbon\Carbon::parse($task->date)->endOfDay(); // La fecha límite incluye todo el día
        $entregadoConRetraso = $submission && \Carbon\Carbon::parse($submission->created_at)->gt($fechaEntrega);
    @endphp

    <tr>
        <!-- Nombre del estudiante -->
        <td class="text-start fw-bold">
            {{ $student->user->name ?? 'Sin nombre' }}
        </td>

        <!-- Estado de la entrega -->
        <td class="text-center">
            @if ($submission)
                <span class="badge {{ $entregadoConRetraso ? 'bg-warning text-dark' : 'bg-success' }}">
                    {{ $entregadoConRetraso ? 'Entregado con retraso' : 'Entregado' }}
                </span>
            @else
                <span class="badge bg-danger">No entregado</span>
            @endif
        </td>

        <!-- Archivo entregado y fecha -->
        <td class="text-center">
            @if ($submission)
                <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank"
                    class="btn btn-custom-green btn-sm">
                    <i class="fas fa-file-pdf"></i> Ver PDF
                </a>
                <p class="mt-1 text-muted" style="font-size: 0.9rem;">
                    <strong>Última entrega:</strong>
                    {{ \Carbon\Carbon::parse($submission->created_at)->format('d/m/Y H:i') }}
                </p>
            @else
                <span class="text-muted">Sin archivo</span>
            @endif
        </td>
    </tr>
@endforeach


                </tbody>

            </table>
        </div>
    @endif
</div>

<style>
    .text-green {
        color: #14b8a6;
        font-weight: 700;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead {
        background-color: #13a292;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    /* Botón personalizado */
    .btn-custom-green {
        border-color: #14b8a6;
        color: #14b8a6;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-custom-green:hover {
        background-color: #14b8a6;
        color: white;
    }

    .badge {
        padding: 0.5em 0.75em;
        font-size: 0.85rem;
        border-radius: 0.25rem;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }
</style>
@endsection
@extends('layouts.adminLayout')

@section('title', 'Detalles de la Tarea')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">
        Detalles de la Tarea: <span class="text-green">{{ $task->name }}</span>
    </h1>

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
                        <th>Última Entrega (PDF)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($task->students as $student)
                        <tr>
                            <!-- Nombre del estudiante -->
                            <td class="text-start fw-bold">
                                {{ $student->user->name ?? 'Sin nombre' }}
                            </td>

                            <!-- Última entrega -->
                            <td class="text-center">
                                @if ($task->student_pdf) <!-- Accede directamente al campo en la tabla tasks -->
                                    <a href="{{ asset('storage/' . $task->student_pdf) }}" target="_blank" 
                                       class="btn btn-custom-green btn-sm">
                                        <i class="fas fa-file-pdf"></i> Ver PDF
                                    </a>
                                @else
                                    <span class="text-muted">Sin entrega</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Estilos personalizados -->
<style>
    /* Título personalizado */
    .text-green {
        color: #14b8a6; /* Verde personalizado */
        font-weight: 700;
    }

    /* Tabla */
    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead {
        background-color: #13a292; /* Verde claro */
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
</style>
@endsection

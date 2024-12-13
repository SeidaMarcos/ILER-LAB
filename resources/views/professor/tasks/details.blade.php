@extends('layouts.adminLayout')

@section('title', 'Detalles de la Tarea')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Detalles de la Tarea: {{ $task->name }}</h1>

    @if ($task->students->isEmpty())
        <p class="text-center text-muted">No hay estudiantes asociados a esta tarea.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre del Estudiante</th>
                    <th>Última Entrega (PDF)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($task->students as $student)
                    <tr>
                        <td>{{ $student->user->name ?? 'Sin nombre' }}</td>
                        <td>
                            @if ($task->student_pdf) <!-- Accede directamente al campo en la tabla tasks -->
                                <a href="{{ asset('storage/' . $task->student_pdf) }}" target="_blank" class="btn btn-info">
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
    @endif
</div>
@endsection

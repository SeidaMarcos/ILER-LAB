@extends('layouts.adminLayout')

@section('title', 'Mis Tareas')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Mis Tareas</h1>

    @if ($tasks->isEmpty())
        <p class="text-center text-muted">No tienes tareas asignadas.</p>
    @else
        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-4 mb-4">
                    <div class="card task-card h-100 shadow-lg border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-white" style="background-color: #13a292; padding: 10px; border-radius: 5px;">
                                {{ $task->name }}
                            </h5>
                            <p class="card-text mt-3"><strong>Descripción:</strong> {{ \Illuminate\Support\Str::limit($task->description, 50) }}</p>
                            <p class="card-text"><strong>Prioridad:</strong> 
                                <span class="badge text-white" style="background-color: 
                                    {{ $task->priority === 'baja' ? '#28a745' : 
                                       ($task->priority === 'media' ? '#ffc107' : 
                                       ($task->priority === 'alta' ? '#fd7e14' : '#dc3545')) }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </p>
                            <p class="card-text"><strong>Progreso:</strong> {{ $task->progress }}%</p>
                            <p class="card-text"><strong>Fecha de Entrega:</strong> {{ \Carbon\Carbon::parse($task->date)->format('d/m/Y') }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center" style="background-color: #e8f5f5;">
                            @if ($task->pdf)
                                <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank" class="btn btn-sm text-white" style="background-color: #13a292;">
                                    <i class="fas fa-file-pdf"></i> Ver PDF
                                </a>
                            @else
                                <span class="text-muted">Sin archivo</span>
                            @endif
                            <a href="{{ route('student.details', $task->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-info-circle"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

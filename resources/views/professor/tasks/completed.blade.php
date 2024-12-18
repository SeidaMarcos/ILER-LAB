@extends('layouts.adminLayout')

@section('title', 'Tareas Realizadas')

@section('content')

<a href="{{ route('professor.dashboard') }}" class="btn btn-light">
    <i class="fas fa-arrow-left"></i>
</a>

<div class="container mt-5">
    <h1 class="text-center mb-4">Tareas Realizadas/Pendientes</h1>

    @if ($tasks->isEmpty())
        <p class="text-center text-muted">No hay tareas asignadas.</p>
    @else
        <div class="row">
            @foreach ($tasks as $task)
                @php
                    // Contar entregas realizadas y pendientes
                    $totalStudents = $task->students->count();
                    $submittedCount = $task->submissions->count(); // Usamos la relación submissions
                    $pendingCount = $totalStudents - $submittedCount;
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card task-card h-100 shadow-lg border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-white" style="background-color: #13a292; padding: 10px; border-radius: 5px;">
                                {{ $task->name }}
                            </h5>

                            <!-- Mostrar entregas realizadas y pendientes -->
                            <p class="card-text mt-3">
                                <strong>Entregas:</strong> 
                                <span class="text-success">{{ $submittedCount }}</span> / 
                                <span class="text-muted">{{ $totalStudents }}</span> 
                                <small>(Pendientes: <span class="text-danger">{{ $pendingCount }}</span>)</small>
                            </p>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center" style="background-color: #e8f5f5;">
                            <a href="{{ route('professor.tasks.details', $task->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-info-circle"></i> Ver Entregas
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

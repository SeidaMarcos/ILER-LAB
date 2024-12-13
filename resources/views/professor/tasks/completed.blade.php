@extends('layouts.adminLayout')

@section('title', 'Tareas Realizadas')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Tareas Realizadas</h1>

    @if ($tasks->isEmpty())
        <p class="text-center text-muted">No hay tareas asignadas.</p>
    @else
        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-4 mb-4">
                    <div class="card task-card h-100 shadow-lg border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-white" style="background-color: #13a292; padding: 10px; border-radius: 5px;">
                                {{ $task->name }}
                            </h5>

                            <p class="card-text"><strong>Entregas:</strong> 
                              
                                {{ $task->students->filter(function ($student) use ($task) {
                                    return $task->student_pdf !== null;
                                })->count() }} /
                                {{ $task->students->count() }}
                            </p>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center" style="background-color: #e8f5f5;">
                            <a href="{{ route('professor.tasks.details', $task->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-info-circle"></i> Ver Entrega
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

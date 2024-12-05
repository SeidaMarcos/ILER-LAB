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
                    <div class="card shadow-lg border-0">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->name }}</h5>
                            <p>{{ $task->description }}</p>
                            <p><strong>Entregas:</strong> 
                                {{ $task->students->where('pivot.student_pdf', '!=', null)->count() }} /
                                {{ $task->students->count() }}
                            </p>
                            <a href="{{ route('professor.task.details', $task->id) }}" class="btn btn-primary">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

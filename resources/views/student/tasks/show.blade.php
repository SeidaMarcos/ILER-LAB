@extends('layouts.userLayout')

@section('title', 'Detalles de la Tarea')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Detalles de la Tarea</h1>

    <div class="card">
        <div class="card-header">
            <h2>{{ $task->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Descripción:</strong> {{ $task->description }}</p>
            <p><strong>Prioridad:</strong> {{ ucfirst($task->priority) }}</p>
            <p><strong>Progreso:</strong> {{ ucfirst($task->progress) }}%</p>
            <p><strong>Fecha de Entrega:</strong> 
                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') : 'No asignada' }}
            </p>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection

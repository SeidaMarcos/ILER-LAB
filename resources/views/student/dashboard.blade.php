@extends('layouts.userLayout')

@section('title', 'Dashboard del Estudiante')

@section('update-route')
    {{ route('student.updateProfile') }}
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Tareas Disponibles</h1>

    @if($tasks->isEmpty())
        <p class="text-center">No hay tareas disponibles.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Prioridad</th>
                    <th>Progreso</th>
                    <th>Fecha de Entrega</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ ucfirst($task->priority) }}</td>
                        <td>{{ ucfirst($task->progress) }}%</td>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') : 'No asignada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

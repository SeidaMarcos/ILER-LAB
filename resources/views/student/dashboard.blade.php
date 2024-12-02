@extends('layouts.adminLayout')

@section('title', 'Mis Tareas')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Mis Tareas</h1>

    @if ($tasks->isEmpty())
        <p class="text-center text-muted">No tienes tareas asignadas.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Prioridad</th>
                    <th>Progreso</th>
                    <th>Fecha de Entrega</th>
                    <th>Archivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ ucfirst($task->priority) }}</td>
                        <td>{{ $task->progress }}%</td>
                        <td>{{ $task->date }}</td>
                        <td>
                            @if ($task->pdf)
                                <a href="{{ asset('storage/' . $task->pdf) }}" target="_blank">Ver PDF</a>
                            @else
                                No disponible
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

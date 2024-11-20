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
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->name }}</td>
                        <td>
                            <a href="{{ route('student.tasks.show', $task->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-eye"></i> 
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

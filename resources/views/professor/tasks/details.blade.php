@extends('layouts.adminLayout')

@section('title', 'Detalles de Tarea')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Detalles de Tarea: {{ $task->name }}</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Entrega</th>
                <th>Estado</th>
                <th>Comentarios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $data)
                <tr>
                    <td>{{ $data['student']->name }}</td>
                    <td>
                        @if ($data['delivered'])
                            <a href="{{ asset('storage/' . $task->student_pdf) }}" target="_blank">Ver PDF</a>
                        @else
                            Pendiente
                        @endif
                    </td>
                    <td>{{ $data['feedback']->status ?? 'Pendiente' }}</td>
                    <td>{{ $data['feedback']->comments ?? 'Sin comentarios' }}</td>
                    <td>
                        <form action="{{ route('professor.task.feedback', [$task->id, $data['student']->id]) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select">
                                <option value="pendiente">Pendiente</option>
                                <option value="aprobado">Aprobado</option>
                                <option value="rechazado">Rechazado</option>
                            </select>
                            <input type="text" name="comments" placeholder="Comentarios" class="form-control mt-2">
                            <button type="submit" class="btn btn-success mt-2">Guardar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

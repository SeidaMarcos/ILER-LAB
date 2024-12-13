@extends('layouts.adminLayout')

@section('title', 'Dashboard de Administración')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5 text-dark">Gestión de Profesores</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profesores Registrados -->
    <div class="card shadow-sm mb-5">
        <div class="card-header" style="background-color: #14b8a6; color: white;">
            <h2 class="mb-0">Profesores Registrados</h2>
        </div>
        <div class="card-body">
            @if($registeredProfessors->isEmpty())
                <p class="text-center text-muted">No hay profesores registrados.</p>
            @else
                <table class="table">
                    <thead style="background-color: #f0fdfa;">
                        <tr>
                            <th style="width: 40%;">Nombre</th>
                            <th style="width: 40%;">Correo Electrónico</th>
                            <th style="width: 20%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registeredProfessors as $professor)
                            <tr>
                                <td>{{ $professor->name }}</td>
                                <td>{{ $professor->email }}</td>
                                <td>
                                    <!-- Botón Editar -->
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editProfessorModal-{{ $professor->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Modal para editar profesor -->
                                    <div class="modal fade" id="editProfessorModal-{{ $professor->id }}" tabindex="-1"
                                        aria-labelledby="editProfessorModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.updateProfessor', $professor->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editProfessorModalLabel">
                                                            Editar Profesor
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label for="name">Nombre</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $professor->name }}" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="email">Correo Electrónico</label>
                                                            <input type="email" name="email" class="form-control"
                                                                value="{{ $professor->email }}" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="password">Nueva Contraseña</label>
                                                            <input type="password" name="password" class="form-control"
                                                                placeholder="Dejar vacío para no cambiar">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                                            <input type="password" name="password_confirmation" class="form-control"
                                                                placeholder="Confirmar Contraseña">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit" class="btn" style="background-color: #14b8a6; color: white;">
                                                            Guardar Cambios
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('admin.deleteProfessor', $professor->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este profesor?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Profesores Pendientes -->
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: #14b8a6; color: white;">
            <h2 class="mb-0">Profesores Pendientes</h2>
        </div>
        <div class="card-body">
            @if($pendingProfessors->isEmpty())
                <p class="text-center text-muted">No hay solicitudes pendientes para profesores.</p>
            @else
                <table class="table">
                    <thead style="background-color: #f0fdfa;">
                        <tr>
                            <th style="width: 40%;">Nombre</th>
                            <th style="width: 40%;">Correo Electrónico</th>
                            <th style="width: 20%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingProfessors as $professor)
                            <tr>
                                <td>{{ $professor->name }}</td>
                                <td>{{ $professor->email }}</td>
                                <td>
                                    <a href="{{ route('admin.approve', $professor->id) }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-check"></i> 
                                    </a>
                                    <a href="{{ route('admin.reject', $professor->id) }}" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-times"></i> 
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
    .btn {
        transition: background-color 0.3s, transform 0.2s;
    }
    .btn:hover {
        transform: scale(1.05);
    }
    .btn-outline-secondary {
        color: #14b8a6;
        border-color: #14b8a6;
    }
    .btn-outline-secondary:hover {
        background-color: #14b8a6;
        color: white;
    }
</style>

@extends('layouts.adminLayout')

@section('title', 'Dashboard de Administración')

@section('content')

<div class="container mt-5">
    <h1 class="text-center mb-4">Gestión de Profesores</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profesores Registrados -->
    <h2 class="mt-5">Profesores Registrados</h2>
    @if($registeredProfessors->isEmpty())
        <p class="text-center">No hay profesores registrados.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registeredProfessors as $professor)
                    <tr>
                        <td>{{ $professor->name }}</td>
                        <td>{{ $professor->email }}</td>
                        <td>
                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
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
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i>
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
                                <button type="submit" class="btn btn-danger btn-sm"
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

    <!-- Profesores Pendientes -->
    <h2 class="mt-5">Profesores Pendientes</h2>
    @if($pendingProfessors->isEmpty())
        <p class="text-center">No hay solicitudes pendientes para profesores.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingProfessors as $professor)
                    <tr>
                        <td>{{ $professor->name }}</td>
                        <td>{{ $professor->email }}</td>
                        <td>
                            <a href="{{ route('admin.approve', $professor->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Aprobar
                            </a>
                            <a href="{{ route('admin.reject', $professor->id) }}" class="btn btn-danger btn-sm">
                                <i class="fas fa-times"></i> Rechazar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

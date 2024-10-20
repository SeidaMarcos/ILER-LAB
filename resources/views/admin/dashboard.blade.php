@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Bienvenido, Administrador</h1>
    <p>Esta es la vista del dashboard del administrador.</p>

    <!-- Menú desplegable de perfil -->
    <div class="dropdown">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user"></i> Perfil
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">Editar Perfil</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf 
                    <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Modal para editar los datos del administrador -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para editar los datos del administrador -->
                    <form action="{{ route('admin.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Nueva Contraseña (opcional):</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Dejar en blanco para mantener la actual">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Nueva Contraseña:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirmar nueva contraseña">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de registros pendientes -->
    <h2>Registros Pendientes</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $registration)
                <tr>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ ucfirst($registration->role) }}</td>
                    <td>
                        <form action="{{ route('admin.registrations.approve', $registration->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Aprobar</button>
                        </form>
                        <form action="{{ route('admin.registrations.reject', $registration->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Rechazar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay registros pendientes.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<!-- Sección de usuarios registrados -->
<h2>Usuarios Registrados</h2>
<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <!-- Excluir al usuario administrador (ID 1) de la lista -->
            @if($user->id_rol != 1)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Mostrar el rol basado en id_rol -->
                        @if($user->id_rol == 2)
                            Profesor
                        @elseif($user->id_rol == 3)
                            Estudiante
                        @else
                            Desconocido
                        @endif
                    </td>
                    <td>
                        <!-- Botón para abrir el modal de edición -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Editar</button>
                    </td>
                </tr>

                <!-- Modal para editar usuario -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario para editar el usuario -->
                                <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="name">Nombre:</label>
                                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Correo Electrónico:</label>
                                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Nueva Contraseña (opcional):</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Dejar en blanco para mantener la actual">
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Nueva Contraseña:</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirmar nueva contraseña">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </tbody>
</table>
@endsection

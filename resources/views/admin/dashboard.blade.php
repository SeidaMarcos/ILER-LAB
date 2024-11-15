<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Bienvenido, {{ auth()->user()->name }}</h1>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Menú desplegable de perfil -->
            <div class="dropdown">
                <a class="btn dropdown-toggle text-white" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #14b8a6;">
                    <i class="fas fa-user"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit"></i> Editar Perfil
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Botón Ver Lista de Tareas con ícono -->
            <a href="{{ route('tasks.index') }}" class="btn text-white" style="background-color: #14b8a6;">
                <i class="fas fa-tasks"></i> Tareas
            </a>
        </div>

        <!-- Modal para editar perfil -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre:</label>
                                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico:</label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Nueva Contraseña (opcional):</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Dejar en blanco para mantener la actual">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Nueva
                                    Contraseña:</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" placeholder="Confirmar nueva contraseña">
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
        <h2 class="mt-4">Registros Pendientes</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
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
                        <td>
                            @if($registration->role == 'professor')
                                Profesor
                            @elseif($registration->role == 'student')
                                Estudiante
                            @else
                                Desconocido
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.registrations.approve', $registration->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                            </form>
                            <form action="{{ route('admin.registrations.reject', $registration->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay registros pendientes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Sección de usuarios registrados -->
        <h2 class="mt-4">Usuarios Registrados</h2>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @if($user->id_rol != 1)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->id_rol == 2)
                                    Profesor
                                @elseif($user->id_rol == 3)
                                    Estudiante
                                @else
                                    Desconocido
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal para editar usuario -->
                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Editar Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="name{{ $user->id }}" class="form-label">Nombre:</label>
                                                <input type="text" id="name{{ $user->id }}" name="name"
                                                    value="{{ $user->name }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email{{ $user->id }}" class="form-label">Correo Electrónico:</label>
                                                <input type="email" id="email{{ $user->id }}" name="email"
                                                    value="{{ $user->email }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password{{ $user->id }}" class="form-label">Nueva Contraseña
                                                    (opcional):</label>
                                                <input type="password" id="password{{ $user->id }}" name="password"
                                                    class="form-control" placeholder="Dejar en blanco para mantener la actual">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_confirmation{{ $user->id }}" class="form-label">Confirmar
                                                    Nueva Contraseña:</label>
                                                <input type="password" id="password_confirmation{{ $user->id }}"
                                                    name="password_confirmation" class="form-control"
                                                    placeholder="Confirmar nueva contraseña">
                                            </div>
                                            <div class="mb-3">
                                                <label for="role{{ $user->id }}" class="form-label">Rol:</label>
                                                <select id="role{{ $user->id }}" name="role" class="form-select" required>
                                                    <option value="2" {{ $user->id_rol == 2 ? 'selected' : '' }}>Profesor</option>
                                                    <option value="3" {{ $user->id_rol == 3 ? 'selected' : '' }}>Estudiante
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
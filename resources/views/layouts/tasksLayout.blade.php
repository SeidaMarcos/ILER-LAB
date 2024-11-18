<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .btn-custom {
            background-color: #14b8a6;
            color: white;
        }

        .btn-custom:hover {
            background-color: #13a292;
            color: white;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <!-- Botones en la misma línea -->
        <div class="action-buttons mb-4">
            @if(Route::currentRouteName() === 'tasks.index')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-custom">
                    <i class="fas fa-arrow-left"></i> 
                </a>
            @else
                <a href="{{ route('tasks.index') }}" class="btn btn-custom">
                    <i class="fas fa-arrow-left"></i> 
                </a>
            @endif

            <!-- Menú desplegable de perfil -->
            <div class="dropdown">
                <a class="btn btn-custom dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-bs-toggle="dropdown" aria-expanded="false">
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
                            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
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
                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña:</label>
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

        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

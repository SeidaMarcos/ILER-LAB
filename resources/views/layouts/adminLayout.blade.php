<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app2.css')
    <link rel="icon" href="{{ asset('logo-2-transparente.png') }}" type="image/png">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Enlace dinámico según el rol del usuario -->
            <a class="navbar-brand" href="
             @if (Auth::user()->isAdmin()) {{ route('admin.dashboard') }}
             @elseif (Auth::user()->isStudent())
                {{ route('student.dashboard') }}
            @elseif (Auth::user()->isProfessor())
                {{ route('professor.dashboard') }}
            @else
            {{ route('home') }} @endif
                ">
                @if (Auth::user()->isAdmin())
                    Panel Admin
                @elseif (Auth::user()->isStudent())
                    Panel Estudiante
                @elseif (Auth::user()->isProfessor())
                    Panel Profesor
                @else
                    User Panel
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModal">
                                    <i class="fas fa-user-edit me-2"></i>Editar Perfil</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Modal para Editar Perfil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.update.profile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name">Nombre Completo</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ Auth::user()->name }}"
                                pattern="^[a-zA-ZÀ-ÿ\u00f1\u00d1]+ [a-zA-ZÀ-ÿ\u00f1\u00d1]+ [a-zA-ZÀ-ÿ\u00f1\u00d1]+$"
                                title="Debe incluir nombre y dos apellidos separados por espacios" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Nueva Contraseña (Opcional)</label>
                            <input type="password" name="password" id="password" class="form-control" minlength="6"
                                title="La contraseña debe tener al menos 6 caracteres">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fas fa-times"></i></button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
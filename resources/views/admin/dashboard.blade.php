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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Registro de Usuario')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4 shadow-lg" style="max-width: 500px; width: 100%; background-color: #efefef;">
            <h2 class="text-center mb-4" style="color: #010407;">Registro de Usuario</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf 
                
                <div class="form-group mb-3">
                    <label for="name" style="color: #010407;">Nombre Completo:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Ingresa tu nombre completo" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email" style="color: #010407;">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Ingresa tu correo electrónico" value="{{ old('email') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password" style="color: #010407;">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Crea una contraseña" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation" style="color: #010407;">Confirmar Contraseña:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirma tu contraseña" required>
                </div>

                <div class="form-group mb-4">
                    <label for="role" style="color: #010407;">Registrarse como:</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                        <option value="professor" {{ old('role') == 'professor' ? 'selected' : '' }}>Profesor</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-custom-shared btn-login-custom btn-block">Registrarse</button>
            </form>

            <p class="text-center mt-3" style="color: #010407;">¿Ya tienes una cuenta? 
                <a href="{{ url('/login') }}" style="color: #7dd3fc;">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
@endsection

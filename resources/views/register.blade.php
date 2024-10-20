@extends('layouts.app')

@section('title', 'Registro de Usuario')

@section('content')
    <h2>Registro de Usuario</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf <!-- Protección CSRF -->
        <div class="form-group">
            <label for="name">Nombre Completo:</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Ingresa tu nombre completo" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Ingresa tu correo electrónico" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Crea una contraseña" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirma tu contraseña" required>
        </div>
        <div class="form-group">
            <label for="role">Registrarse como:</label>
            <select id="role" name="role" class="form-control" required>
                <option value="" disabled selected>Selecciona una opción</option>
                <option value="student">Estudiante</option>
                <option value="professor">Profesor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="{{ url('/') }}">Inicia sesión aquí</a></p>
@endsection

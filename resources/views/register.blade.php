@extends('layouts.app')

@section('title', 'Registro de Usuario')

@section('content')
    <h2>Registro de Usuario</h2>
    <form>
        @csrf <!-- Protección CSRF -->
        <div class="form-group">
            <label for="name">Nombre Completo:</label>
            <input type="text" id="name" name="name" placeholder="Ingresa tu nombre completo" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Crea una contraseña" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirma tu contraseña" required>
        </div>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="{{ url('/') }}">Inicia sesión aquí</a></p>
@endsection

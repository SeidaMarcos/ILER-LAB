@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
    <h2>Iniciar Sesión</h2>
    <form>
        @csrf <!-- Protección CSRF -->
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
        </div>
        <button type="submit">Ingresar</button>
    </form>
    <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
@endsection

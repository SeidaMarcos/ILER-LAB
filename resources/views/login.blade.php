@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%; background-color: #efefef;">
            <h2 class="text-center mb-4" style="color: #010407;">Iniciar Sesión</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf 
                <div class="form-group mb-3">
                    <label for="email" style="color: #010407;">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Ingresa tu correo electrónico" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password" style="color: #010407;">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                </div>

                <button type="submit" class="btn btn-block" style="background-color: #14b8a6; color: #efefef;">Ingresar</button>
            </form>

            <p class="text-center mt-3" style="color: #010407;">¿No tienes una cuenta? 
                <a href="{{ route('register') }}" style="color: #7dd3fc;">Regístrate aquí</a>
            </p>
        </div>
    </div>
@endsection
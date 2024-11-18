@extends('layouts.app')

@section('title', 'Página de Inicio - RPA Automatización')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="mb-4" style="color: #010407;">Bienvenido al Panel de Gestión de IlerLab</h1>
        <a href="{{ route('login') }}" class="btn btn-lg m-2 btn-custom-shared btn-login-custom">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="btn btn-lg m-2 btn-custom-shared btn-register-custom">Registrarse</a>

    </div>
</div>
@endsection
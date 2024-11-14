@extends('layouts.app')

@section('title', 'Página de Inicio - RPA Automatización')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="mb-4" style="color: #010407;">Bienvenido al Panel de Gestión de IlerLab</h1>
        <a href="{{ route('login') }}" class="btn btn-lg m-2" style="background-color: #14b8a6; color: #efefef; border: none;">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="btn btn-lg m-2" style="color: #010407; border: 2px solid #7dd3fc;">Registrarse</a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Bienvenido, Administrador</h1>
    <p>Esta es la vista del dashboard del administrador.</p>

    
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf 
        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
    </form>
@endsection

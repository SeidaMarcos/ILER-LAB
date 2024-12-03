@extends('layouts.adminLayout')

@section('title', 'Panel del Profesor')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Panel del Profesor</h1>

    <div class="row">
        <!-- Ver/Crear Tareas -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Ver/Crear Tareas</h5>
                    <p class="card-text">Gestiona las tareas, crea nuevas tareas o edita las existentes.</p>
                    <a href="{{ route('professor.tasks.panel') }}" class="btn btn-primary">
                        <i class="fas fa-tasks"></i> Ver/Crear Tareas
                    </a>
                </div>
            </div>
        </div>

        <!-- Tareas Realizadas -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Tareas Realizadas</h5>
                    <p class="card-text">Revisa y gestiona las tareas entregadas por los estudiantes.</p>
                    <a href="{{ route('professor.tasks.completed') }}" class="btn btn-success">
                        <i class="fas fa-check-circle"></i> Tareas Realizadas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

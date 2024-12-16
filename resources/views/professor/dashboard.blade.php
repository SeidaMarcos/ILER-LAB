@extends('layouts.adminLayout')

@section('title', 'Panel del Profesor')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Panel del Profesor</h1>

    <div class="row justify-content-center">
        <!-- Ver/Crear Tareas -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-lg hover-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-tasks fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Ver/Crear Tareas</h5>
                    <p class="text-secondary">Gestiona las tareas, crea nuevas tareas o edita las existentes.</p>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="{{ route('professor.tasks.panel') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-tasks"></i> Ver/Crear Tareas
                    </a>
                </div>
            </div>
        </div>

        <!-- Tareas Realizadas -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-lg hover-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold">Tareas Realizadas</h5>
                    <p class="text-secondary">Revisa y gestiona las tareas entregadas por los estudiantes.</p>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="{{ route('professor.tasks.completed') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-check-circle"></i> Tareas Realizadas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        min-height: 280px; 
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .card-body i {
        margin-bottom: 10px;
    }

    .row {
        row-gap: 20px;
    }
</style>
@endsection

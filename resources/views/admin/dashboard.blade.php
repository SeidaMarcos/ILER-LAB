@extends('layouts.adminLayout')

@section('title', 'Dashboard de Administración')

@section('content')

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-center mb-5 text-dark">Panel de Administración</h1>

    <div class="row gy-4">
        <!-- Card Estudiantes -->
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-lg border-0 rounded-lg hover-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-graduate fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Estudiantes</h5>
                    <p class="text-success mb-1"><strong>{{ $approvedStudentsCount }}</strong> Aprobados</p>
                    <p class="text-danger"><strong>{{ $pendingStudentsCount }}</strong> Pendientes</p>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="{{ route('admin.students') }}" class="btn btn-primary btn-sm">Ver Estudiantes</a>
                </div>
            </div>
        </div>

        <!-- Card Profesores -->
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-lg border-0 rounded-lg hover-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-chalkboard-teacher fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title fw-bold">Profesores</h5>
                    <p class="text-success mb-1"><strong>{{ $approvedProfessorsCount }}</strong> Aprobados</p>
                    <p class="text-danger"><strong>{{ $pendingProfessorsCount }}</strong> Pendientes</p>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="{{ route('admin.professors') }}" class="btn btn-warning btn-sm">Ver Profesores</a>
                </div>
            </div>
        </div>

        <!-- Card Tareas -->
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-lg border-0 rounded-lg hover-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-tasks fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold">Tareas</h5>
                    <p class="text-info"><strong>{{ $tasksCount }}</strong> Creadas</p>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="{{ route('admin.tasks.panel') }}" class="btn btn-success btn-sm">Ver Tareas</a>
                </div>
            </div>
        </div>

        <!-- Card Inventario -->
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-lg border-0 rounded-lg hover-card h-100 d-flex flex-column justify-content-between">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-boxes fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title fw-bold">Inventario</h5>
                    <p><strong>{{ $machinesCount }}</strong> Máquinas</p>
                    <p><strong>{{ $productsCount }}</strong> Productos</p>
                    <p><strong>{{ $toolsCount }}</strong> Herramientas</p>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="{{ route('inventory.index') }}" class="btn btn-info btn-sm">Ver Inventario</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

@extends('layouts.adminLayout')

@section('title', 'Dashboard de Administración')

@section('content')

<div class="container">
    <!-- Mostrar mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-5">
        <h1 class="text-center mb-4">Panel de Administración</h1>
        <div class="row">
            <!-- Card Estudiantes -->
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $approvedStudentsCount }}</h3>
                        <p>Estudiantes Aprobados</p>
                        <h5>{{ $pendingStudentsCount }}</h5>
                        <p>Estudiantes Pendientes</p>
                        <a href="{{ route('admin.students') }}" class="btn btn-primary">Ver Estudiantes</a>
                    </div>
                </div>
            </div>

            <!-- Card Profesores -->
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $approvedProfessorsCount }}</h3>
                        <p>Profesores Aprobados</p>
                        <h5>{{ $pendingProfessorsCount }}</h5>
                        <p>Profesores Pendientes</p>
                        <a href="{{ route('admin.professors') }}" class="btn btn-primary">Ver Profesores</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Tareas -->
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ $tasksCount }}</h3>
                <p>Tareas Creadas</p>
                <a href="{{ route('admin.tasks.panel') }}" class="btn btn-primary">Ver Tareas</a>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
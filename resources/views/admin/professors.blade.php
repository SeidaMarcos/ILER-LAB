@extends('layouts.adminLayout')

@section('title', 'Dashboard de Administración')

@section('content')

    <div class="container mt-5">
        <h1 class="text-center mb-4">Profesores Pendientes</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($pendingProfessors->isEmpty())
            <p class="text-center">No hay solicitudes pendientes para profesores.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingProfessors as $professor)
                        <tr>
                            <td>{{ $professor->name }}</td>
                            <td>{{ $professor->email }}</td>
                            <td>
                                <a href="{{ route('admin.approve', $professor->id) }}"
                                    class="btn btn-success btn-sm">Aprobar</a>
                                <a href="{{ route('admin.reject', $professor->id) }}" class="btn btn-danger btn-sm">Rechazar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <!-- Profesores Registrados -->
        <h2>Registrados</h2>
        @if($registeredProfessors->isEmpty())
            <p class="text-center">No hay profesores registrados.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registeredProfessors as $professor)
                        <tr>
                            <td>{{ $professor->name }}</td>
                            <td>{{ $professor->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
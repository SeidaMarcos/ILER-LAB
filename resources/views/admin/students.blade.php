@extends('layouts.adminLayout')

@section('title', 'Dashboard de Administración')

@section('content')

<div class="container mt-5">
    <h1 class="text-center mb-4">Gestión de Estudiantes</h1>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario de Búsqueda -->
    <form action="{{ route('admin.students') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Buscar por Nombre"
                    value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <input type="email" name="email" class="form-control" placeholder="Buscar por Correo"
                    value="{{ request('email') }}">
            </div>
            <div class="col-md-2">
                <select name="curso" class="form-control">
                    <option value="">Seleccionar Curso</option>
                    <option value="1º" {{ request('curso') == '1º' ? 'selected' : '' }}>1º</option>
                    <option value="2º" {{ request('curso') == '2º' ? 'selected' : '' }}>2º</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="ciclo" class="form-control">
                    <option value="">Seleccionar Ciclo</option>
                    <option value="anatomia" {{ request('ciclo') == 'anatomia' ? 'selected' : '' }}>Anatomía</option>
                    <option value="laboratorio" {{ request('ciclo') == 'laboratorio' ? 'selected' : '' }}>Laboratorio
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>

    <!-- Resultado de la Búsqueda -->
    @if($filteredStudents->isEmpty() && request()->hasAny(['name', 'email', 'curso', 'ciclo']))
        <p class="text-danger text-center">No se encontraron estudiantes que coincidan con el filtro.</p>
    @else
        <h2 class="mt-4">Estudiantes Registrados</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Ciclo</th>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filteredStudents as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->student->ciclo }}</td>
                        <td>{{ $student->student->curso }}</td>
                        <td>
                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editStudentModal-{{ $student->id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Modal para editar estudiante -->
                            <div class="modal fade" id="editStudentModal-{{ $student->id }}" tabindex="-1"
                                aria-labelledby="editStudentModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.updateStudent', $student->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStudentModalLabel">Editar Estudiante</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group mb-3">
                                                    <label for="name">Nombre</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ $student->name }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="email">Correo Electrónico</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $student->email }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="ciclo">Ciclo</label>
                                                    <select name="ciclo" class="form-control">
                                                        <option value="anatomia" {{ $student->student->ciclo == 'anatomia' ? 'selected' : '' }}>Anatomía</option>
                                                        <option value="laboratorio" {{ $student->student->ciclo == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="curso">Curso</label>
                                                    <select name="curso" class="form-control">
                                                        <option value="1º" {{ $student->student->curso == '1º' ? 'selected' : '' }}>1º</option>
                                                        <option value="2º" {{ $student->student->curso == '2º' ? 'selected' : '' }}>2º</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="password">Nueva Contraseña</label>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Dejar vacío para no cambiar">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        placeholder="Confirmar Contraseña">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón Eliminar -->
                            <form action="{{ route('admin.deleteStudent', $student->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Estás seguro de eliminar este estudiante?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    <!-- Estudiantes Pendientes -->
    <h2 class="mt-5">Pendientes de Aprobación</h2>
    @if($pendingStudents->isEmpty())
        <p class="text-center">No hay solicitudes pendientes para estudiantes.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Ciclo</th>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingStudents as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->ciclo }}</td>
                        <td>{{ $student->curso }}</td>
                        <td>
                            <a href="{{ route('admin.approve', $student->id) }}" class="btn btn-success btn-sm">Aprobar</a>
                            <a href="{{ route('admin.reject', $student->id) }}" class="btn btn-danger btn-sm">Rechazar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
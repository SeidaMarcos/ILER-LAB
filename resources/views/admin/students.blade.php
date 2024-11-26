<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                    <input type="text" name="name" class="form-control" placeholder="Buscar por Nombre" value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control" placeholder="Buscar por Correo" value="{{ request('email') }}">
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
                        <option value="laboratorio" {{ request('ciclo') == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Resultado de la Búsqueda -->
        @if($filteredStudents->isEmpty() && request()->hasAny(['name', 'email', 'curso', 'ciclo']))
            <p class="text-danger text-center">No se encontraron estudiantes que coincidan con el filtro.</p>
        @elseif(!$filteredStudents->isEmpty())
            <h2 class="mt-4">Resultados de la Búsqueda</h2>
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
                                <!-- Acciones personalizadas -->
                                <a href="#" class="btn btn-info btn-sm">Ver Detalles</a>
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
</body>

</html>

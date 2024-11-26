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

        <!-- Mensajes de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Estudiantes Pendientes -->
        <h2>Pendientes de Aprobación</h2>
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

        <!-- Estudiantes Registrados -->
        <h2>Estudiantes Registrados</h2>
        @foreach ($registeredStudents as $ciclo => $cursos)
            <h3 class="mt-4">Ciclo: {{ ucfirst($ciclo) }}</h3>
            @foreach ($cursos as $curso => $students)
                <h4>Curso: {{ $curso }}</h4>
                @if ($students->isEmpty())
                    <p>No hay estudiantes registrados en este ciclo y curso.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo Electrónico</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endforeach
        @endforeach
    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores Pendientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Profesores Pendientes</h1>
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
                            <a href="{{ route('admin.approve', $professor->id) }}" class="btn btn-success btn-sm">Aprobar</a>
                            <a href="{{ route('admin.reject', $professor->id) }}" class="btn btn-danger btn-sm">Rechazar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>

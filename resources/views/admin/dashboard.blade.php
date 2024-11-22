<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Registros Pendientes</h1>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Ciclo</th>
            <th>Curso</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registrations as $registration)
        <tr>
            <td>{{ $registration->name }}</td>
            <td>{{ $registration->email }}</td>
            <td>{{ $registration->role }}</td>
            <td>{{ $registration->ciclo }}</td>
            <td>{{ $registration->curso }}</td>
            <td>
                <a href="{{ route('admin.approve', $registration->id) }}">Aprobar</a>
                <a href="{{ route('admin.reject', $registration->id) }}">Rechazar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
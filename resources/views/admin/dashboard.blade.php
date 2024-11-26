<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
</body>
</html>

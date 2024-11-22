<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css') 
</head>
<body>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="mb-4" style="color: #010407;">Bienvenido al Panel de Gestión de IlerLab</h1>
        <a href="{{ route('login') }}" class="btn btn-lg m-2 btn-custom-shared btn-login-custom">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="btn btn-lg m-2 btn-custom-shared btn-register-custom">Registrarse</a>

    </div>
</div>

</body>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</html>

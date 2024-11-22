<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
</html>

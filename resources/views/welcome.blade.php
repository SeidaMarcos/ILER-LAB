<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Bienvenido al Panel de Gestión de IlerLab</h1>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-teal-500 text-white rounded-lg text-lg hover:bg-teal-600">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="px-6 py-3 border-2 border-blue-300 text-blue-700 rounded-lg text-lg hover:bg-blue-300 hover:text-white">Registrarse</a>
        </div>
    </div>
</body>
</html>

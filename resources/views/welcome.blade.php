<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-xl text-center">
        <img src="images/Logo.png" alt="Logo IlerLab" class="w-[300px] h-[100px] mx-auto mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Bienvenido al Panel de Gestión de IlerLab</h1>
        <div class="space-x-4">
            <a href="{{ route('login') }}" 
               class="inline-block px-6 py-3 bg-teal-500 text-white rounded-lg text-lg hover:bg-teal-600 transform hover:scale-105 transition-transform duration-300">
               Iniciar sesión
            </a>
            <a href="{{ route('register') }}" 
               class="inline-block px-6 py-3 bg-blue-300 text-white rounded-lg text-lg hover:bg-blue-400 transform hover:scale-105 transition-transform duration-300">
               Registrarse
            </a>
        </div>
    </div>
</body>
</html>

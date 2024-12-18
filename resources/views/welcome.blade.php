<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">
    <div class="bg-white p-6 sm:p-8 md:p-10 lg:p-12 rounded-lg shadow-xl text-center w-full max-w-md sm:max-w-lg md:max-w-xl">

        <img src="images/Logo.png" alt="Logo IlerLab" 
        class="mx-auto mb-6 w-[150px] sm:w-[200px] md:w-[250px] lg:w-[300px] h-auto">
        
        <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-6">
            Bienvenido al Panel de Gestión de IlerLab
        </h1>
        
        <div class="space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('login') }}" 
               class="block sm:inline-block px-6 py-3 bg-teal-500 text-white rounded-lg text-sm sm:text-base lg:text-lg hover:bg-teal-600 transform hover:scale-105 transition-transform duration-300">
               Iniciar sesión
            </a>
            <a href="{{ route('register') }}" 
               class="block sm:inline-block px-6 py-3 bg-blue-300 text-white rounded-lg text-sm sm:text-base lg:text-lg hover:bg-blue-400 transform hover:scale-105 transition-transform duration-300">
               Registrarse
            </a>
        </div>
    </div>
</body>
</html>

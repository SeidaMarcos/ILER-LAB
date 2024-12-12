<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- Correo Electrónico -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold">Correo Electrónico:</label>
                <input type="email" name="email" id="email" placeholder="Correo Electrónico" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                       value="{{ old('email') }}" required>
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="Contraseña" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                       required>
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botón de Iniciar Sesión -->
            <button type="submit" class="w-full bg-teal-500 text-white py-3 rounded-lg hover:bg-teal-600 transition duration-200">Iniciar Sesión</button>

            <!-- Enlace al Registro -->
            <p class="text-center mt-4 text-gray-700">
                ¿No tienes cuenta? <a href="{{ route('register.form') }}" class="text-teal-500 hover:underline">Regístrate aquí</a>
            </p>
        </form>
    </div>
</body>
</html>

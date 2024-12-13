<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold">Nombre Completo:</label>
                <input type="text" name="name" id="name" placeholder="Nombre y Apellidos"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                       value="{{ old('name') }}" required>
                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Correo -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold">Correo Electrónico:</label>
                <input type="email" name="email" id="email" placeholder="Correo Electrónico"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                       value="{{ old('email') }}" required>
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold">Contraseña:</label>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Contraseña"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                           required>
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon1" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmar contraseña -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-bold">Confirmar Contraseña:</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar Contraseña"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                           required>
                    <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon2" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Rol -->
            <div class="mb-4">
                <label for="role" class="block text-gray-700 font-bold">Selecciona tu Rol:</label>
                <select name="role" id="role"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        onchange="toggleStudentFields()" required>
                    <option value="" disabled {{ old('role') === null ? 'selected' : '' }}>Seleccionar Rol</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                    <option value="professor" {{ old('role') == 'professor' ? 'selected' : '' }}>Profesor</option>
                </select>
                @error('role')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Campos específicos de estudiante -->
            <div id="student-fields" class="{{ old('role') == 'student' ? '' : 'hidden' }}">
                <div class="mb-4">
                    <label for="ciclo" class="block text-gray-700 font-bold">Ciclo:</label>
                    <select name="ciclo" id="ciclo"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="" disabled {{ old('ciclo') === null ? 'selected' : '' }}>Seleccionar Ciclo</option>
                        <option value="anatomia" {{ old('ciclo') == 'anatomia' ? 'selected' : '' }}>Anatomía</option>
                        <option value="laboratorio" {{ old('ciclo') == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                    </select>
                    @error('ciclo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="curso" class="block text-gray-700 font-bold">Curso:</label>
                    <select name="curso" id="curso"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="" disabled {{ old('curso') === null ? 'selected' : '' }}>Seleccionar Curso</option>
                        <option value="1º" {{ old('curso') == '1º' ? 'selected' : '' }}>1º</option>
                        <option value="2º" {{ old('curso') == '2º' ? 'selected' : '' }}>2º</option>
                    </select>
                    @error('curso')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Botón de registro -->
            <button type="submit" class="w-full bg-teal-500 text-white py-3 rounded-lg hover:bg-teal-600 transition duration-200">Registrarse</button>

            <!-- Enlace al inicio de sesión -->
            <p class="text-center mt-4 text-gray-700">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-teal-500 hover:underline">Inicia sesión aquí</a>
            </p>
        </form>
    </div>
</body>
<script>
    function toggleStudentFields() {
        const role = document.querySelector('select[name="role"]').value;
        const studentFields = document.getElementById('student-fields');
        studentFields.classList.toggle('hidden', role !== 'student');
    }

        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        togglePassword.addEventListener('click', () => {
            passwordInput.type = passwordInput.type === 'text' ? 'password' : 'text';
        });

        toggleConfirmPassword.addEventListener('click', () => {
            confirmPasswordInput.type = confirmPasswordInput.type === 'text' ? 'password' : 'text';
        });
</script>
</html>

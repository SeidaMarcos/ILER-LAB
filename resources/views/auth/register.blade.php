<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css') 
</head>
<body>
    <div class="full-height-container">
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Mensajes de error generales -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Nombre -->
            <div class="form-group">
                <label for="name">Nombre Completo:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nombre y Apellidos" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Correo -->
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Correo Electrónico" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmación de contraseña -->
            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña:</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirmar Contraseña" required>
            </div>

            <!-- Selección de rol -->
            <div class="form-group">
                <label for="role">Selecciona tu Rol:</label>
                <select name="role" id="role" class="form-control" onchange="toggleStudentFields()" required>
                    <option value="" disabled {{ old('role') === null ? 'selected' : '' }}>Seleccionar Rol</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                    <option value="professor" {{ old('role') == 'professor' ? 'selected' : '' }}>Profesor</option>
                </select>
                @error('role')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Campos específicos de estudiante -->
            <div id="student-fields" style="display: {{ old('role') == 'student' ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="ciclo">Ciclo:</label>
                    <select name="ciclo" id="ciclo" class="form-control">
                        <option value="" disabled {{ old('ciclo') === null ? 'selected' : '' }}>Seleccionar Ciclo</option>
                        <option value="anatomia" {{ old('ciclo') == 'anatomia' ? 'selected' : '' }}>Anatomía</option>
                        <option value="laboratorio" {{ old('ciclo') == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                    </select>
                    @error('ciclo')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="curso">Curso:</label>
                    <select name="curso" id="curso" class="form-control">
                        <option value="" disabled {{ old('curso') === null ? 'selected' : '' }}>Seleccionar Curso</option>
                        <option value="1º" {{ old('curso') == '1º' ? 'selected' : '' }}>1º</option>
                        <option value="2º" {{ old('curso') == '2º' ? 'selected' : '' }}>2º</option>
                    </select>
                    @error('curso')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Botón de registro -->
            <button type="submit" class="btn btn-custom-shared btn-login-custom">Registrarse</button>

            <!-- Enlace al Inicio de Sesión -->
            <p class="text-center mt-3">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="btn-register-link">Inicia sesión aquí</a>
            </p>
        </form>
    </div>
</body>
<script>
    // Mostrar u ocultar campos dependiendo del rol seleccionado
    function toggleStudentFields() {
        const role = document.querySelector('select[name="role"]').value;
        const studentFields = document.getElementById('student-fields');
        if (role === 'student') {
            studentFields.style.display = 'block';
        } else {
            studentFields.style.display = 'none';
        }
    }
</script>
</html>

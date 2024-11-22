<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nombre Completo:</label>
            <input type="text" name="name" id="name" placeholder="Nombre y Apellidos" value="{{ old('name') }}" required>
            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" placeholder="Correo Electrónico" value="{{ old('email') }}" required>
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
            @error('password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar Contraseña" required>
        </div>

        <div>
            <label for="role">Selecciona tu Rol:</label>
            <select name="role" id="role" onchange="toggleStudentFields()" required>
                <option value="" disabled {{ old('role') === null ? 'selected' : '' }}>Seleccionar Rol</option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                <option value="professor" {{ old('role') == 'professor' ? 'selected' : '' }}>Profesor</option>
            </select>
            @error('role')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div id="student-fields" style="display: {{ old('role') == 'student' ? 'block' : 'none' }};">
            <label for="ciclo">Ciclo:</label>
            <select name="ciclo" id="ciclo">
                <option value="" disabled {{ old('ciclo') === null ? 'selected' : '' }}>Seleccionar Ciclo</option>
                <option value="anatomia" {{ old('ciclo') == 'anatomia' ? 'selected' : '' }}>Anatomía</option>
                <option value="laboratorio" {{ old('ciclo') == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
            </select>
            @error('ciclo')
                <span style="color: red;">{{ $message }}</span>
            @enderror

            <label for="curso">Curso:</label>
            <select name="curso" id="curso">
                <option value="" disabled {{ old('curso') === null ? 'selected' : '' }}>Seleccionar Curso</option>
                <option value="1º" {{ old('curso') == '1º' ? 'selected' : '' }}>1º</option>
                <option value="2º" {{ old('curso') == '2º' ? 'selected' : '' }}>2º</option>
            </select>
            @error('curso')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Registrarse</button>
    </form>
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

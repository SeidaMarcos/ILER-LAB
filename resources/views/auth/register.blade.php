<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nombre completo" required>
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
    <select name="role" onchange="toggleStudentFields()" required>
        <option value="student">Estudiante</option>
        <option value="professor">Profesor</option>
    </select>
    <div id="student-fields" style="display: none;">
        <select name="ciclo">
            <option value="anatomia">Anatomía</option>
            <option value="laboratorio">Laboratorio</option>
        </select>
        <select name="curso">
            <option value="1º">1º</option>
            <option value="2º">2º</option>
        </select>
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

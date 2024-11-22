<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nombre completo" required>
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
    <select name="role" required>
        <option value="student">Estudiante</option>
        <option value="professor">Profesor</option>
    </select>
    <div id="student-fields">
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
</html>
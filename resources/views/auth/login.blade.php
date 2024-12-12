<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="full-height-container">
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- Correo Electrónico -->
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

            <!-- Botón de Iniciar Sesión -->
            <button type="submit" class="btn-custom-shared btn-login-custom">Iniciar Sesión</button>

            <!-- Enlace al Registro -->
            <p class="text-center mt-3">
                ¿No tienes cuenta? 
                <a href="{{ route('register.form') }}" class="btn-register-link">Regístrate aquí</a>
            </p>
        </form>
    </div>
</body>
</html>

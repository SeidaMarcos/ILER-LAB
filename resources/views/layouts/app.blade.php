<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - IlerLab</title>
    @vite('resources/css/app.css') 
    @stack('styles') 
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
    @stack('scripts') 
</body>
</html>

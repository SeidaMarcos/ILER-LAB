<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Mostrar la vista de inicio de sesión
    public function showLoginForm()
    {
        return view('login');
    }

    // Mostrar la vista de registro
    public function showRegistrationForm()
    {
        return view('register');
    }
}

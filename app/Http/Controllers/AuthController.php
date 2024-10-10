<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    
    // Procesar el inicio de sesión
    public function login(Request $request)
    {
        // Validar los campos de inicio de sesión
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirigir según el rol
            $user = Auth::user();
            if ($user->id_rol == 1) { // Asumiendo que el ID 1 es el rol de Administrador
                return redirect()->route('admin.dashboard');
            }

            // Redirigir a home para otros roles
            return redirect()->route('home');
        }

        // Si falla la autenticación, redirigir de vuelta con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

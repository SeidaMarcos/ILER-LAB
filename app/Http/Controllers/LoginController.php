<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar el login
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Verificar las credenciales
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Validar si el usuario está activo (aprobado por el admin)
            if (!$user->active) {
                Auth::logout();
                return back()->withErrors(['error' => 'Tu cuenta aún no ha sido aprobada por el administrador.']);
            }

            // Redirigir según el rol del usuario
            if ($user->role->name === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name === 'professor') {
                return redirect()->route('professor.dashboard');
            } elseif ($user->role->name === 'student') {
                return redirect()->route('student.dashboard');
            }

            // Si el rol no es válido
            Auth::logout();
            return back()->withErrors(['error' => 'Rol no reconocido. Contacta al administrador.']);
        }

        // Si las credenciales no son válidas
        return back()->withErrors(['error' => 'Credenciales incorrectas.']);
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}

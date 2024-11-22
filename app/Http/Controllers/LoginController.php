<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Verificar si el correo está en pendientes
        $pending = PendingRegistration::where('email', $request->email)->first();
        if ($pending) {
            return back()->withErrors(['email' => 'Tu cuenta está pendiente de aprobación por el administrador.']);
        }

        // Verificar si el correo está registrado en la tabla de usuarios
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'El correo electrónico no está registrado.']);
        }

        // Intentar autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirigir según el rol del usuario
            if ($user->role->name === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name === 'professor') {
                return redirect()->route('professor.dashboard');
            } elseif ($user->role->name === 'student') {
                return redirect()->route('student.dashboard');
            }

            // Si el rol no es reconocido
            Auth::logout();
            return back()->withErrors(['email' => 'Rol no reconocido. Contacta al administrador.']);
        }

        // Contraseña incorrecta
        return back()->withErrors(['password' => 'La contraseña no es correcta.']);
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}

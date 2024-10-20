<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


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

    // Procesar el registro del usuario
    public function register(Request $request)
    {
        // Validar los datos de registro
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:pending_registrations,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:student,professor'],
        ]);

        // Guardar en la tabla de registros pendientes
        DB::table('pending_registrations')->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Registro enviado para aprobación. Espera la confirmación del administrador.');
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

            // Redirigir según el rol del usuario autenticado
            $user = Auth::user();
            if ($user->id_rol == 1) { 
                return redirect()->route('admin.dashboard');
            } elseif ($user->id_rol == 2) { 
                return redirect()->route('teacher.dashboard');
            } elseif ($user->id_rol == 3) { 
                return redirect()->route('student.dashboard');
            }

            // Si el rol no coincide con ninguno, redirigir a una ruta por defecto
            return redirect()->route('home');
        }

        // Si falla la autenticación, redirigir de vuelta con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros, o falta de la aprobación del administrador.',
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

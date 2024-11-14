<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User; 


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

    public function register(Request $request)
{
    // Mensajes de error personalizados
    $messages = [
        'name.required' => 'El nombre completo es obligatorio.',
        'name.regex' => 'El nombre debe incluir al menos un apellido.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser una dirección válida.',
        'email.unique' => 'Este correo electrónico ya está registrado.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 5 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'role.required' => 'Debe seleccionar un rol.',
        'role.in' => 'El rol seleccionado no es válido.',
    ];

    // Validar los datos de registro con los mensajes personalizados
    $data = $request->validate([
        'name' => [
            'required',
            'string',
            'regex:/^[a-záéíóúñ]+(\s[a-záéíóúñ]+)+$/i', // Validación para nombre con al menos un apellido
            'max:255',
        ],
        'email' => [
            'required',
            'email',
            'max:255',
            function ($attribute, $value, $fail) {
                // Comprobar si el correo ya existe en la tabla de usuarios
                if (User::where('email', $value)->exists()) {
                    $fail('Este correo electrónico ya está registrado.');
                }
                // Comprobar si el correo ya está en los registros pendientes
                if (DB::table('pending_registrations')->where('email', $value)->exists()) {
                    $fail('Este correo electrónico ya ha sido registrado previamente y está pendiente de aprobación.');
                }
            }
        ],
        'password' => ['required', 'string', 'min:5', 'confirmed'], // Validación para un mínimo de 5 caracteres
        'role' => ['required', 'in:student,professor'],
    ], $messages);

    // Convertir el nombre a mayúsculas antes de guardarlo
    $data['name'] = strtoupper($data['name']);

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

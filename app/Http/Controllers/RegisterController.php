<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Mostrar el formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Procesar el registro
    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'El nombre completo es obligatorio.',
            'name.regex' => 'El nombre debe incluir al menos un nombre y dos apellidos, y solo puede contener letras y espacios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está registrado o pendiente de aprobación.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'role.required' => 'Debe seleccionar un rol.',
            'role.in' => 'El rol seleccionado no es válido.',
            'ciclo.required_if' => 'El ciclo es obligatorio para estudiantes.',
            'ciclo.in' => 'El ciclo seleccionado no es válido.',
            'curso.required_if' => 'El curso es obligatorio para estudiantes.',
            'curso.in' => 'El curso seleccionado no es válido.',
        ];

        $request->validate([
            'name' => [
                'required',
                'regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+(\s[A-ZÁÉÍÓÚÑa-záéíóúñ]+){2,}$/', // Mínimo un nombre y dos apellidos
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:pending_registrations,email',
                'unique:users,email',
            ],
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:student,professor',
            'ciclo' => 'required_if:role,student|in:anatomia,laboratorio',
            'curso' => 'required_if:role,student|in:1º,2º',
        ], $messages);

        PendingRegistration::create([
            'name' => strtoupper($request->name), // Convertir nombre a mayúsculas
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'ciclo' => $request->role == 'student' ? $request->ciclo : null,
            'curso' => $request->role == 'student' ? $request->curso : null,
        ]);

        return redirect()->route('login')->with('success', 'Registro enviado para aprobación.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar el formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Procesar el registro
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pending_registrations,email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:student,professor',
            'ciclo' => 'required_if:role,student|in:anatomia,laboratorio',
            'curso' => 'required_if:role,student|in:1º,2º',
        ]);

        PendingRegistration::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'ciclo' => $request->role == 'student' ? $request->ciclo : null,
            'curso' => $request->role == 'student' ? $request->curso : null,
        ]);

        return redirect()->route('login')->with('success', 'Registro enviado para aprobación.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Mostrar el dashboard con las solicitudes pendientes
    public function dashboard()
    {
        $registrations = PendingRegistration::all(); // Obtener registros pendientes
        return view('admin.dashboard', compact('registrations')); // Pasar la variable a la vista
    }

    // Aprobar una solicitud
    public function approveRegistration($id)
{
    $registration = PendingRegistration::findOrFail($id);

    // Crear el usuario en la tabla users
    $user = User::create([
        'name' => $registration->name,
        'email' => $registration->email,
        'password' => $registration->password, // Ya está encriptada
        'role_id' => $registration->role == 'student' ? 3 : 2, // 3: student, 2: professor
    ]);

    // Si el rol es student, crear el registro en la tabla students
    if ($registration->role == 'student') {
        $user->student()->create([
            'ciclo' => $registration->ciclo,
            'curso' => $registration->curso,
        ]);
    }

    // Eliminar el registro pendiente
    $registration->delete();

    return redirect()->route('admin.dashboard')->with('success', 'Registro aprobado.');
}


    // Rechazar una solicitud
    public function rejectRegistration($id)
    {
        $registration = PendingRegistration::findOrFail($id);
        $registration->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Registro rechazado.');
    }
}
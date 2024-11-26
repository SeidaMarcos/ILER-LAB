<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Mostrar el dashboard con contadores de registros
    public function dashboard()
    {
        $studentsCount = User::where('role_id', 3)->count(); // Contar estudiantes
        $professorsCount = User::where('role_id', 2)->count(); // Contar profesores

        return view('admin.dashboard', compact('studentsCount', 'professorsCount'));
    }

    // Mostrar vista de estudiantes pendientes
    public function students()
    {
        $pendingStudents = PendingRegistration::where('role', 'student')->get();
        return view('admin.students', compact('pendingStudents'));
    }

    // Mostrar vista de profesores pendientes
    public function professors()
    {
        $pendingProfessors = PendingRegistration::where('role', 'professor')->get();
        return view('admin.professors', compact('pendingProfessors'));
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

        // Crear registros adicionales dependiendo del rol
        if ($registration->role == 'student') {
            $user->student()->create([
                'ciclo' => $registration->ciclo,
                'curso' => $registration->curso,
            ]);
        } elseif ($registration->role == 'professor') {
            $user->professor()->create([]);
        }

        // Eliminar el registro pendiente
        $registration->delete();

        return back()->with('success', 'Usuario aprobado correctamente.');
    }

    // Rechazar una solicitud
    public function rejectRegistration($id)
    {
        $registration = PendingRegistration::findOrFail($id);
        $registration->delete();

        return back()->with('success', 'Solicitud rechazada correctamente.');
    }
}

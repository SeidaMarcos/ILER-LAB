<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Mostrar el dashboard con contadores de registros
    public function dashboard()
    {
        // Contar estudiantes aprobados
        $approvedStudentsCount = User::where('role_id', 3)->count();

        // Contar profesores aprobados
        $approvedProfessorsCount = User::where('role_id', 2)->count();

        // Contar estudiantes pendientes
        $pendingStudentsCount = PendingRegistration::where('role', 'student')->count();

        // Contar profesores pendientes
        $pendingProfessorsCount = PendingRegistration::where('role', 'professor')->count();

        return view('admin.dashboard', compact(
            'approvedStudentsCount',
            'approvedProfessorsCount',
            'pendingStudentsCount',
            'pendingProfessorsCount'
        ));
    }

    // Mostrar vista de estudiantes pendientes
    public function students(Request $request)
    {
        // Obtener estudiantes pendientes
        $pendingStudents = PendingRegistration::where('role', 'student')->get();

        // Obtener todos los estudiantes registrados
        $query = User::where('role_id', 3)->with('student');

        // Aplicar filtro si se proporciona
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('curso')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('curso', $request->curso);
            });
        }

        if ($request->filled('ciclo')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('ciclo', $request->ciclo);
            });
        }

        $filteredStudents = $query->get();

        return view('admin.students', compact('pendingStudents', 'filteredStudents'));
    }



    public function professors()
    {
        // Obtener profesores registrados
        $registeredProfessors = User::where('role_id', 2)->get();

        // Obtener profesores pendientes
        $pendingProfessors = PendingRegistration::where('role', 'professor')->get();

        return view('admin.professors', compact('registeredProfessors', 'pendingProfessors'));
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

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validar los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:5', 'confirmed'],
        ]);

        // Actualizar los datos del usuario
        $user->name = strtoupper($request->name);
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Perfil Admin actualizado correctamente.');
    }

    public function updateStudent(Request $request, $id)
{
    $student = User::findOrFail($id);

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
        'ciclo' => ['required', 'in:anatomia,laboratorio'],
        'curso' => ['required', 'in:1º,2º'],
        'password' => ['nullable', 'string', 'min:5', 'confirmed'], // Validar confirmación
    ]);

    // Actualizar los datos del estudiante
    $student->name = strtoupper($request->name);
    $student->email = $request->email;

    // Actualizar ciclo y curso en la tabla 'students'
    $student->student->update([
        'ciclo' => $request->ciclo,
        'curso' => $request->curso,
    ]);

    // Cambiar la contraseña solo si se proporciona
    if ($request->filled('password')) {
        $student->password = Hash::make($request->password);
    }

    $student->save();

    return redirect()->back()->with('success', 'Estudiante actualizado correctamente.');
}


public function deleteStudent($id)
{
    $student = User::findOrFail($id);

    // Eliminar el registro relacionado en la tabla 'students'
    if ($student->student) {
        $student->student->delete();
    }

    $student->delete();

    return redirect()->back()->with('success', 'Estudiante eliminado correctamente.');
}

}
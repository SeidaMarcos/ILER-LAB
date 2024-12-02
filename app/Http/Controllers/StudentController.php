<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Encontrar el estudiante asociado al usuario logueado
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            abort(404, 'Estudiante no encontrado');
        }

        // Obtener las tareas asociadas al estudiante
        $tasks = $student->tasks()->get();

        return view('student.dashboard', compact('tasks'));
    }
}

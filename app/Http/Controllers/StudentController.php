<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Task;

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

    public function taskDetails($id)
    {
        $user = Auth::user();
    
        // Obtener el estudiante asociado al usuario logueado
        $student = Student::where('user_id', $user->id)->first();
    
        if (!$student) {
            abort(404, 'Estudiante no encontrado');
        }
    
        // Verificar si la tarea está asociada al estudiante y cargar relaciones
        $task = $student->tasks()
            ->with(['tools', 'machines', 'products']) // Cargar herramientas, máquinas y productos
            ->where('tasks.id', $id)
            ->first();
    
        if (!$task) {
            abort(403, 'No estás autorizado para ver esta tarea.');
        }
    
        return view('student.details', compact('task'));
    }
    
    public function uploadTask(Request $request, $id)
    {
        $user = Auth::user();
    
        // Encontrar el estudiante asociado al usuario logueado
        $student = Student::where('user_id', $user->id)->first();
    
        if (!$student) {
            abort(404, 'Estudiante no encontrado');
        }
    
        // Verificar si la tarea está asociada al estudiante
        $task = $student->tasks()->where('tasks.id', $id)->first();
    
        if (!$task) {
            abort(403, 'No estás autorizado para entregar esta tarea.');
        }
    
        // Validar el archivo PDF con mensajes personalizados
        $request->validate(
            [
                'student_pdf' => 'required|file|mimes:pdf|max:2048',
            ],
            [
                'student_pdf.required' => 'Es obligatorio subir un archivo.',
                'student_pdf.file' => 'El archivo debe ser válido.',
                'student_pdf.mimes' => 'El archivo debe ser un PDF.',
                'student_pdf.max' => 'El tamaño del archivo no debe exceder los 2MB.',
            ]
        );
    
        // Subir el archivo PDF
        if ($request->hasFile('student_pdf')) {
            $studentPdfPath = $request->file('student_pdf')->store('student_uploads', 'public'); // Subir archivo al almacenamiento público
            $task->student_pdf = $studentPdfPath; // Guardar la ruta en la base de datos
            $task->save(); // Guardar los cambios
        }
    
        return redirect()->route('student.dashboard')->with('success', 'Tarea entregada correctamente.');
    }
    

}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Task;
use App\Models\TaskSubmission;


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
    
    public function uploadTask(Request $request, $taskId)
    {
        $user = Auth::user();
    
        // Obtener el estudiante asociado al usuario logueado
        $student = Student::where('user_id', $user->id)->first();
    
        if (!$student) {
            abort(404, 'Estudiante no encontrado');
        }
    
        // Verificar si la tarea existe
        $task = Task::findOrFail($taskId);
    
        // Validar el archivo PDF
        $request->validate([
            'student_pdf' => 'required|file|mimes:pdf|max:2048',
        ], [
            'student_pdf.required' => 'Es obligatorio subir un archivo.',
            'student_pdf.file' => 'El archivo debe ser válido.',
            'student_pdf.mimes' => 'El archivo debe ser un PDF.',
            'student_pdf.max' => 'El tamaño del archivo no debe exceder los 2MB.',
        ]);
    
        // Subir el archivo PDF
        if ($request->hasFile('student_pdf')) {
            $filePath = $request->file('student_pdf')->store('task_submissions', 'public');
    
            // Buscar la entrega existente
            $submission = TaskSubmission::where('student_id', $student->id)
                ->where('task_id', $task->id)
                ->first();
    
            if ($submission) {
                // Actualizar el archivo y la fecha de creación
                $submission->update([
                    'file_path' => $filePath,
                ]);
    
                // Forzar la actualización del campo created_at
                $submission->created_at = now();
                $submission->save();
            } else {
                // Crear una nueva entrega si no existe
                TaskSubmission::create([
                    'student_id' => $student->id,
                    'task_id' => $task->id,
                    'file_path' => $filePath,
                ]);
            }
        }
    
        return redirect()->route('student.dashboard', $taskId)
            ->with('success', 'Tarea entregada correctamente.');
    }
    

}

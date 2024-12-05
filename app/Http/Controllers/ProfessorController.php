<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Student;
use App\Models\Feedback;

class ProfessorController extends Controller
{
    // Panel del profesor
    public function dashboard()
    {
        return view('professor.dashboard');
    }

    // Panel para ver/crear tareas
    public function panelTasks()
    {
        $tasks = Task::all(); // Todas las tareas disponibles
        return view('professor.tasks.panel', compact('tasks'));
    }

    // Tareas realizadas por estudiantes
    public function completedTasks()
    {
        $tasks = Task::with('students')->get(); // Obtener tareas con estudiantes asociados
        return view('professor.tasks.completed', compact('tasks'));
    }

    // Detalles de una tarea específica
    public function taskDetails($id)
    {
        $task = Task::with('students')->findOrFail($id);

        $students = $task->students->map(function ($student) use ($task) {
            $feedback = Feedback::where('task_id', $task->id)
                ->where('student_id', $student->id)
                ->first();
            return [
                'student' => $student,
                'feedback' => $feedback,
                'delivered' => $task->student_pdf ? true : false,
            ];
        });

        return view('professor.tasks.details', compact('task', 'students'));
    }

    // Guardar retroalimentación
    public function submitFeedback(Request $request, $taskId, $studentId)
    {
        $request->validate([
            'comments' => 'nullable|string|max:500',
            'status' => 'required|in:pendiente,aprobado,rechazado',
        ]);

        Feedback::updateOrCreate(
            ['task_id' => $taskId, 'student_id' => $studentId],
            ['comments' => $request->comments, 'status' => $request->status]
        );

        return redirect()->route('professor.task.details', $taskId)->with('success', 'Feedback guardado correctamente.');
    }
}

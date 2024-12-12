<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Student;

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
            return [
                'student' => $student,
                'delivered' => $task->student_pdf ? true : false,
            ];
        });

        return view('professor.tasks.details', compact('task', 'students'));
    }
}

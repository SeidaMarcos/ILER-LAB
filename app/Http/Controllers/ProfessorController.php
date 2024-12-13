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
 
    public function completedTasks()
{
    $tasks = Task::all();

    return view('professor.tasks.completed', compact('tasks'));
}


public function taskDetails($id)
{
    // Cargar la tarea específica con estudiantes relacionados
    $task = Task::with(['students.user'])->findOrFail($id); // Relación con estudiantes y usuarios

    return view('professor.tasks.details', compact('task'));
}






}

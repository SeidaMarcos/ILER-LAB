<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Task;

class ProfessorController extends Controller
{
    public function dashboard()
    {
        return view('professor.dashboard');
    }

    public function panelTasks()
    {
        $tasks = Task::all(); 
        return view('professor.tasks.panel', compact('tasks'));
    }
    

    public function completedTasks()
    {
        return view('professor.tasks.completed');
    }
}

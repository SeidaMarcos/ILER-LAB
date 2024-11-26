<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Mostrar el panel de tareas
    public function index()
    {
        $tasks = Task::orderBy('date', 'asc')->get(); // Ordenar las tareas por fecha
        return view('admin.tasks.panel', compact('tasks')); // Pasar las tareas a la vista
    }

    // Mostrar formulario para crear una nueva tarea
    public function create()
    {
        return view('admin.tasks.create');
    }

    // Guardar una nueva tarea
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'in:baja,media,alta,urgente'],
            'progress' => ['required', 'in:0,25,50,75,100'],
            'date' => ['required', 'date'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'], // Validación para PDF
        ]);

        // Subir archivo PDF si está presente
        $pdfPath = $request->file('pdf') ? $request->file('pdf')->store('tasks', 'public') : null;

        // Crear la tarea en la base de datos
        Task::create([
            'description' => $request->description,
            'priority' => $request->priority,
            'progress' => $request->progress,
            'date' => $request->date,
            'pdf' => $pdfPath,
        ]);

        return redirect()->route('admin.tasks.panel')->with('success', 'Tarea creada correctamente.');
    }

    // Eliminar una tarea
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Eliminar archivo PDF asociado
        if ($task->pdf) {
            \Storage::delete('public/' . $task->pdf);
        }

        $task->delete();

        return redirect()->route('admin.tasks.panel')->with('success', 'Tarea eliminada correctamente.');
    }
}

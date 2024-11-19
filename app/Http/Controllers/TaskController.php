<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        // Validar los datos entrantes
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:baja,media,alta,urgente',
            'progress' => 'required|in:0,25,50,75,100',
            'due_date' => 'nullable|date|after_or_equal:today',
            'pdf' => 'nullable|mimes:pdf|max:2048', // Validación para archivos PDF
        ]);
    
        // Preparar los datos para guardar
        $data = $request->only(['name', 'description', 'priority', 'progress', 'due_date']);
    
        // Si se sube un archivo PDF, procesarlo
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('tasks', 'public'); // Guardar en storage/app/public/tasks
            $data['pdf_path'] = $pdfPath; // Guardar la ruta en la base de datos
        }
    
        // Crear la tarea
        Task::create($data);
    
        // Redirigir con mensaje de éxito
        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente.');
    }
    
    

    public function update(Request $request, Task $task)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|in:baja,media,alta,urgente',
        'progress' => 'required|in:0,25,50,75,100',
        'due_date' => 'nullable|date|after_or_equal:today',
        'pdf' => 'nullable|mimes:pdf|max:2048', // Validar archivo PDF
    ]);

    $taskData = $request->all();

    if ($request->hasFile('pdf')) {
        if ($task->pdf_path) {
            Storage::disk('public')->delete($task->pdf_path); // Eliminar archivo anterior si existe
        }
        $taskData['pdf_path'] = $request->file('pdf')->store('tasks', 'public');
    }

    $task->update($taskData);

    return redirect()->route('tasks.index')->with('success', 'Tarea actualizada exitosamente.');
}


    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente.');
    }

}

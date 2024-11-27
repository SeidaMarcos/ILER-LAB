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
        $request->validate(
            [
                'description' => 'required|string|max:255',
                'priority' => 'required|in:baja,media,alta,urgente',
                'progress' => 'required|in:0,25,50,75,100',
                'date' => ['required', 'date', 'after_or_equal:today'],
                'pdf' => 'nullable|file|mimes:pdf|max:2048',
            ],
            [
                'pdf.mimes' => 'Solo se pueden adjuntar archivos en formato PDF.',
                'pdf.max' => 'El archivo PDF no debe exceder los 2 MB.',
                'date.required' => 'La fecha es obligatoria.',
                'date.date' => 'El valor ingresado debe ser una fecha válida.',
                'date.after_or_equal' => 'La fecha debe ser igual o posterior a hoy.',
            ]
        );


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

        // Verificar y eliminar el archivo PDF asociado
        if ($task->pdf && \Storage::disk('public')->exists($task->pdf)) {
            \Storage::disk('public')->delete($task->pdf);
        }

        // Eliminar la tarea
        $task->delete();

        return redirect()->route('admin.tasks.panel')->with('success', 'Tarea eliminada correctamente.');
    }



    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('admin.tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate(
            [
                'description' => 'required|string|max:255',
                'priority' => 'required|in:baja,media,alta,urgente',
                'progress' => 'required|in:0,25,50,75,100',
                'date' => ['required', 'date', 'after_or_equal:today'],
                'pdf' => 'nullable|file|mimes:pdf|max:2048',
            ],
            [
                'pdf.mimes' => 'Solo se pueden adjuntar archivos en formato PDF.',
                'pdf.max' => 'El archivo PDF no debe exceder los 2 MB.',
                'date.required' => 'La fecha es obligatoria.',
                'date.date' => 'El valor ingresado debe ser una fecha válida.',
                'date.after_or_equal' => 'La fecha debe ser igual o posterior a hoy.',
            ]
        );


        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->progress = $request->progress;
        $task->date = $request->date;

        if ($request->hasFile('pdf')) {
            if ($task->pdf) {
                Storage::delete($task->pdf);
            }
            $task->pdf = $request->file('pdf')->store('pdfs', 'public');
        }

        $task->save();

        return redirect()->route('admin.tasks.panel')->with('success', 'Tarea actualizada correctamente.');
    }


}

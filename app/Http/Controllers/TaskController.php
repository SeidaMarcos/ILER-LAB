<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:baja,media,alta,urgente',
            'progress' => 'required|in:0,25,50,75,100',
            'due_date' => 'nullable|date|after_or_equal:today',
            'pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'priority', 'progress', 'due_date']);

        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('tasks', 'public');
            $data['pdf_path'] = $pdfPath;
        }

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:baja,media,alta,urgente',
            'due_date' => 'nullable|date|after_or_equal:today',
            'pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Actualizar los campos básicos
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
        $task->due_date = $request->input('due_date');

        // Verificar si el PDF debe eliminarse
        if ($request->input('remove_pdf') == '1') {
            if ($task->pdf_path) {
                Storage::disk('public')->delete($task->pdf_path);
                $task->pdf_path = null; // Eliminar el registro en la base de datos
            }
        }

        // Verificar si hay un nuevo PDF
        if ($request->hasFile('pdf')) {
            // Eliminar el PDF actual si existe
            if ($task->pdf_path) {
                Storage::disk('public')->delete($task->pdf_path);
            }

            // Guardar el nuevo archivo PDF
            $filePath = $request->file('pdf')->store('tasks', 'public');
            $task->pdf_path = $filePath;
        }

        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada correctamente.');
    }


    public function destroy(Task $task)
    {
        if ($task->pdf_path) {
            Storage::disk('public')->delete($task->pdf_path);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente.');
    }

}

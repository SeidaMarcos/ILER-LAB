<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Student;

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




    // Mostrar y filtrar formulario para crear una nueva tarea
    public function create(Request $request)
    {
        $query = User::where('role_id', 3); // Filtrar estudiantes (role_id = 3)

        // Aplicar filtros si existen
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('ciclo')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('ciclo', $request->ciclo);
            });
        }
        if ($request->filled('curso')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('curso', $request->curso);
            });
        }

        $students = $query->get(); // Obtener resultados filtrados
        return view('admin.tasks.create', compact('students'));
    }




    // Guardar una nueva tarea
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'priority' => 'required|in:baja,media,alta,urgente',
            'progress' => 'required|in:0,25,50,75,100',
            'date' => ['required', 'date', 'after_or_equal:today'],
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'students' => ['required', 'array'], // Validar que se seleccionen estudiantes
        ]);

        // 1. Subir archivo PDF si existe
        $pdfPath = $request->file('pdf') ? $request->file('pdf')->store('tasks', 'public') : null;

        // 2. Crear la tarea en la base de datos
        $task = Task::create([
            'description' => $request->description,
            'priority' => $request->priority,
            'progress' => $request->progress,
            'date' => $request->date,
            'pdf' => $pdfPath,
        ]);

        // 3. Verificar y asociar estudiantes
        $validStudentIds = Student::whereIn('id', $request->students)->pluck('id')->toArray();
        $task->students()->sync($validStudentIds);

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

        // Actualizar datos de la tarea
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->progress = $request->progress;
        $task->date = $request->date;

        // Si se marca "Guardar sin archivo PDF"
        if ($request->has('remove_pdf')) {
            // Eliminar archivo PDF actual si existe
            if ($task->pdf && \Storage::disk('public')->exists($task->pdf)) {
                \Storage::disk('public')->delete($task->pdf);
            }
            $task->pdf = null; // Eliminar referencia en la base de datos
        } elseif ($request->hasFile('pdf')) {
            // Subir un nuevo archivo PDF si no está marcada la opción de "Guardar sin archivo PDF"
            if ($task->pdf && \Storage::disk('public')->exists($task->pdf)) {
                \Storage::disk('public')->delete($task->pdf); // Eliminar archivo anterior
            }
            $task->pdf = $request->file('pdf')->store('tasks', 'public'); // Guardar nuevo archivo
        }

        $task->save();

        return redirect()->route('admin.tasks.panel')->with('success', 'Tarea actualizada correctamente.');
    }
}
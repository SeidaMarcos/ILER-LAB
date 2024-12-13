<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Product;
use App\Models\Tool;
use App\Models\Machine;

class ProfessorTaskController extends Controller
{
    // Mostrar el panel de tareas para el profesor
    public function index()
    {
        $tasks = Task::orderBy('date', 'asc')->get(); // Cambiar lógica si es necesario para el profesor
        return view('professor.tasks.panel', compact('tasks'));
    }

    // Crear nueva tarea
    public function create(Request $request)
    {
        $query = User::where('role_id', 3); // Filtrar estudiantes (role_id = 3)

        // Aplicar filtros
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

        $students = $query->get();
        $tools = Tool::all();
        $machines = Machine::all();
        $products = Product::all();

        return view('professor.tasks.create', compact('students', 'tools', 'machines', 'products'));
    }

    // Guardar nueva tarea
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'priority' => 'required|in:baja,media,alta,urgente',
            'date' => ['required', 'date', 'after_or_equal:today'],
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'students' => ['required', 'array'],
            'tools' => ['nullable', 'array'],
            'machines' => ['nullable', 'array'],
            'products' => ['nullable', 'array'],
        ]);

        $pdfPath = $request->file('pdf') ? $request->file('pdf')->store('tasks', 'public') : null;

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
            'date' => $request->date,
            'pdf' => $pdfPath,
        ]);

        $task->tools()->sync($request->tools ?? []);
        $task->machines()->sync($request->machines ?? []);
        $task->products()->sync($request->products ?? []);

        $validStudentIds = Student::whereIn('id', $request->students)->pluck('id')->toArray();
        $task->students()->sync($validStudentIds);

        return redirect()->route('professor.tasks.index')->with('success', 'Tarea creada correctamente.');
    }

    // Editar tarea
    public function edit(Request $request, $id)
    {
        $task = Task::with('students')->findOrFail($id);

        $query = User::where('role_id', 3);

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

        $students = $query->get();

        return view('professor.tasks.edit', compact('task', 'students'));
    }

    // Actualizar tarea
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'description' => 'required|string|max:255',
            'priority' => 'required|in:baja,media,alta,urgente',
            'date' => ['required', 'date', 'after_or_equal:today'],
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'students' => ['nullable', 'array'],
        ]);

        $task->name = $request->name;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->date = $request->date;

        if ($request->has('remove_pdf')) {
            if ($task->pdf && \Storage::disk('public')->exists($task->pdf)) {
                \Storage::disk('public')->delete($task->pdf);
            }
            $task->pdf = null;
        } elseif ($request->hasFile('pdf')) {
            if ($task->pdf && \Storage::disk('public')->exists($task->pdf)) {
                \Storage::disk('public')->delete($task->pdf);
            }
            $task->pdf = $request->file('pdf')->store('tasks', 'public');
        }

        $task->save();

        if ($request->has('students')) {
            $validStudentIds = Student::whereIn('id', $request->students)->pluck('id')->toArray();
            $task->students()->sync($validStudentIds);
        } else {
            $task->students()->detach();
        }

        return redirect()->route('professor.tasks.index')->with('success', 'Tarea actualizada correctamente.');
    }

    // Eliminar tarea
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if ($task->pdf && \Storage::disk('public')->exists($task->pdf)) {
            \Storage::disk('public')->delete($task->pdf);
        }

        $task->delete();

        return redirect()->route('professor.tasks.index')->with('success', 'Tarea eliminada correctamente.');
    }
}

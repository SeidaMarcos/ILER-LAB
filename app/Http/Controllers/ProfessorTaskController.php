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
        $task = Task::with(['students', 'tools', 'machines', 'products'])->findOrFail($id);

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

        $students = $query->get();
        $tools = Tool::all(); // Obtener herramientas
        $machines = Machine::all(); // Obtener máquinas
        $products = Product::all(); // Obtener productos

        return view('admin.tasks.edit', compact('task', 'students', 'tools', 'machines', 'products'));
    }

    // Actualizar tarea
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'priority' => 'required|in:baja,media,alta,urgente',
                'date' => ['required', 'date', 'after_or_equal:today'],
                'pdf' => 'nullable|file|mimes:pdf|max:2048',
                'students' => ['nullable', 'array'], // Validar estudiantes seleccionados
                'tools' => ['nullable', 'array'], // Validar herramientas seleccionadas
                'machines' => ['nullable', 'array'], // Validar máquinas seleccionadas
                'products' => ['nullable', 'array'], // Validar productos seleccionados
            ],
            [
                'name.required' => 'El nombre de la tarea es obligatorio.',
                'description.required' => 'La descripción de la tarea es obligatoria.',
                'priority.required' => 'La prioridad es obligatoria.',
                'priority.in' => 'La prioridad seleccionada no es válida.',
                'date.required' => 'La fecha de entrega es obligatoria.',
                'date.date' => 'La fecha debe ser válida.',
                'date.after_or_equal' => 'La fecha debe ser igual o posterior a hoy.',
                'pdf.mimes' => 'El archivo debe ser un PDF.',
                'pdf.max' => 'El archivo PDF no debe exceder los 2 MB.',
            ]
        );

        // Actualizar datos de la tarea
        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
            'date' => $request->date,
        ]);

        // Manejo del PDF
        if ($request->has('remove_pdf')) {
            // Eliminar archivo PDF actual si existe
            if ($task->pdf && Storage::disk('public')->exists($task->pdf)) {
                Storage::disk('public')->delete($task->pdf);
            }
            $task->pdf = null; // Eliminar referencia en la base de datos
        } elseif ($request->hasFile('pdf')) {
            // Subir un nuevo archivo PDF
            if ($task->pdf && Storage::disk('public')->exists($task->pdf)) {
                Storage::disk('public')->delete($task->pdf); // Eliminar archivo anterior
            }
            $task->pdf = $request->file('pdf')->store('tasks', 'public'); // Guardar nuevo archivo
        }

        $task->save();

        // Actualizar estudiantes asociados
        if ($request->has('students')) {
            $validStudentIds = Student::whereIn('id', $request->students)->pluck('id')->toArray();
            $task->students()->sync($validStudentIds);
        } else {
            $task->students()->detach(); // Eliminar todos si no se seleccionaron
        }

        // Actualizar herramientas, máquinas y productos
        $task->tools()->sync($request->tools ?? []); // Actualizar herramientas
        $task->machines()->sync($request->machines ?? []); // Actualizar máquinas
        $task->products()->sync($request->products ?? []); // Actualizar productos

        return redirect()->route('admin.tasks.panel')->with('success', 'Tarea actualizada correctamente.');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Task; // Importar el modelo Task

class StudentController extends Controller
{
    // Muestra el dashboard del estudiante con sus datos y las tareas
    public function dashboard()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        
        // Obtener todas las tareas disponibles para los estudiantes
        $tasks = Task::all();
        
        // Devuelve la vista del dashboard del estudiante con los datos y las tareas
        return view('student.dashboard', compact('user', 'tasks'));
    }

    // Actualizar el perfil del estudiante
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/\b\w+\s+\w+\b/', // Al menos un nombre y un apellido
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:5|confirmed',
        ], [
            'name.required' => 'El nombre completo es obligatorio.',
            'name.regex' => 'El nombre debe incluir al menos un apellido.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo debe ser una dirección válida.',
            'password.min' => 'La contraseña debe tener al menos 5 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = Auth::user();
        $user->name = strtoupper($request->input('name')); // Guardar el nombre en mayúsculas
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('student.dashboard')->with('success', 'Perfil actualizado correctamente.');
    }

    public function showTask(Task $task)
{
    return view('student.tasks.show', compact('task'));
}

}

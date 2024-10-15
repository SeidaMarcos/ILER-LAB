<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Asegúrate de importar el modelo User

class AdminController extends Controller
{
    // Mostrar el dashboard del administrador
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Actualizar los datos del administrador
    public function update(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Actualizar los datos del administrador
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save(); // Guardar los cambios en la base de datos

        // Redirigir de vuelta al dashboard con un mensaje de éxito
        return redirect()->route('admin.dashboard')->with('success', 'Datos actualizados correctamente.');
    }
}

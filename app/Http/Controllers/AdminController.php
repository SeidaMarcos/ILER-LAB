<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminController extends Controller
{
    // Mostrar el dashboard del administrador
    public function dashboard()
    {
        // Obtener todos los registros pendientes y todos los usuarios registrados
        $registrations = DB::table('pending_registrations')->get();
        $users = User::all();

        return view('admin.dashboard', compact('registrations', 'users'));
    }

    // Actualizar los datos del administrador
    public function update(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Validar la nueva contraseña si se proporciona
        ]);
    
        // Obtener el usuario autenticado
        $user = Auth::user();
    
        // Actualizar los datos del administrador con el nombre en mayúsculas
        $user->name = strtoupper($request->input('name'));
        $user->email = $request->input('email');
    
        // Solo actualizar la contraseña si se proporciona una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->save(); // Guardar los cambios en la base de datos
    
        // Redirigir de vuelta a la página en la que estaba el usuario, o al dashboard como fallback
        return redirect($request->input('redirect_to', route('admin.dashboard')))
            ->with('success', 'Datos actualizados correctamente.');
    }
    

    // Aprobar un registro pendiente
    public function approveRegistration($id)
    {
        $registration = DB::table('pending_registrations')->find($id);

        if ($registration) {
            // Crear el usuario en la tabla users con el nombre en mayúsculas y el rol correspondiente
            User::create([
                'name' => strtoupper($registration->name),
                'email' => $registration->email,
                'password' => $registration->password, // La contraseña ya está encriptada
                'id_rol' => $registration->role == 'professor' ? 2 : 3, // Asignar el rol: 2 para profesor, 3 para estudiante
            ]);

            // Eliminar el registro pendiente
            DB::table('pending_registrations')->where('id', $id)->delete();

            return redirect()->route('admin.dashboard')->with('success', 'Registro aprobado y usuario creado.');
        }

        return redirect()->route('admin.dashboard')->with('error', 'Registro no encontrado.');
    }

    // Rechazar un registro pendiente
    public function rejectRegistration($id)
    {
        // Eliminar el registro pendiente
        DB::table('pending_registrations')->where('id', $id)->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Registro rechazado y eliminado.');
    }

    // Actualizar los datos de un usuario específico, incluyendo el rol
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validar los datos del formulario
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Validar la nueva contraseña si se proporciona
            'role' => ['required', 'in:2,3'], // Validar que el rol sea profesor (2) o estudiante (3)
        ]);

        // Actualizar los datos del usuario con el nombre en mayúsculas
        $user->name = strtoupper($data['name']);
        $user->email = $data['email'];
        $user->id_rol = $data['role']; // Actualizar el rol del usuario

        // Solo actualizar la contraseña si se proporciona una nueva
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save(); // Guardar los cambios en la base de datos

        // Redirigir de vuelta al dashboard con un mensaje de éxito
        return redirect()->route('admin.dashboard')->with('success', 'Usuario actualizado correctamente.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Verifica si el usuario es el administrador (id_rol = 1)
        if ($user->id_rol == 1) {
            return redirect()->route('admin.dashboard')->with('error', 'No se puede eliminar al administrador.');
        }

        // Eliminar el usuario
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Usuario eliminado correctamente.');
    }
}

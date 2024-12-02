<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Obtener el rol de admin o crearlo si no existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear o actualizar el usuario en la tabla users
        $user = User::updateOrCreate(
            ['email' => 'dani@gmail.com'], // Identificador único
            [
                'name' => 'Dani',
                'password' => bcrypt('password123'),
                'role_id' => $adminRole->id, // Asociar con el rol de admin
                'active' => true, // Cualquier otra columna relevante
            ]
        );

        // Insertar en la tabla admins si no existe
        DB::table('admins')->updateOrInsert(
            ['user_id' => $user->id], // Clave única basada en la relación
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Obtener el rol de admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear el administrador
        User::updateOrCreate(
            ['email' => 'dani@gmail.com'],
            [
                'name' => 'Dani',
                'password' => bcrypt('password123'),
                'role_id' => $adminRole->id,
                'active' => true,
            ]
        );
    }
}


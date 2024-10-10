<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $adminRoleId = DB::table('roles')->where('name', 'Administrador')->first()->id;

        
        DB::table('users')->insert([
            'name' => 'Dani',
            'email' => 'dani@gmail.com',
            'password' => Hash::make('password123'), 
            'id_rol' => $adminRoleId,
        ]);
    }
}


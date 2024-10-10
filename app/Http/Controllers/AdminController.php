<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Método para mostrar el dashboard del administrador
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}

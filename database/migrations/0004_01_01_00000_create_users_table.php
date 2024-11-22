<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del usuario
            $table->string('email')->unique(); // Correo único
            $table->timestamp('email_verified_at')->nullable(); // Verificación de correo
            $table->string('password'); // Contraseña
            $table->boolean('active')->default(true); // Estado del usuario
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Relación con roles
            $table->rememberToken(); // Token para "recordarme"
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
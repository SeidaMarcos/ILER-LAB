<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la tarea
            $table->text('description')->nullable(); // Descripción de la tarea
            $table->enum('priority', ['baja', 'media', 'alta', 'urgente'])->default('media'); // Urgencia de la tarea
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

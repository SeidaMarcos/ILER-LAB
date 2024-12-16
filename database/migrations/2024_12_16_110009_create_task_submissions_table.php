<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('task_id');
            $table->string('file_path'); // Ruta del archivo PDF entregado
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');

            // Clave única para evitar múltiples entregas de la misma tarea por el mismo estudiante
            $table->unique(['student_id', 'task_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_submissions');
    }
}

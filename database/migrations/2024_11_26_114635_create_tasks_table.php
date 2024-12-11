<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{

    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('priority', ['baja', 'media', 'alta', 'urgente']);
            $table->enum('progress', ['0', '25', '50', '75', '100']);
            $table->date('date');
            $table->string('pdf')->nullable(); // Path del archivo PDF
            $table->string('student_pdf')->nullable();
            $table->foreignId('id_task_request')->constrained('tasks');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

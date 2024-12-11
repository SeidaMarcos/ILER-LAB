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
            $table->text('description');
            $table->enum('priority', ['baja', 'media', 'alta', 'urgente']);
            $table->enum('progress', ['0', '25', '50', '75', '100']);
            $table->date('date');
            $table->string('pdf')->nullable(); // Path del archivo PDF
            $table->unsignedBigInteger('id_task_request');
            $table->foreign('id_task_request')->references('id')->on('task_request_table')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

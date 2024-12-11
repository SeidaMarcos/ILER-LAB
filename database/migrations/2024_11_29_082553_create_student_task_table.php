<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTaskTable extends Migration
{
    public function up()
    {
        Schema::create('student_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('id_group')->nullable()->constrained('groups');
            $table->unique(['student_id', 'task_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_task');
    }
}

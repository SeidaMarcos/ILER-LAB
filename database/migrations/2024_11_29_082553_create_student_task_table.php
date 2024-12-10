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
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('id_group')->nullable()->constrained('groups');
            $table->unique(['id_student', 'id_task']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_task');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_student_task')->constrained('student_task')->onDelete('cascade');
            $table->text('comment')->nullable(); // Comentarios del profesor
            $table->enum('status', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente'); // Estado
            $table->foreignId('created_by_professor')->constrained('professors')->onDelete('cascade'); // Relación con profesor
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}

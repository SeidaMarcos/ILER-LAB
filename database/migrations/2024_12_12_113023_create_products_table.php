<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Nombre del producto
            $table->decimal('density', 8, 2);    // Densidad del producto
            $table->string('location');          // Ubicación del producto
            $table->unsignedBigInteger('id_student'); // Relación con estudiante
            $table->unsignedBigInteger('id_task');    // Relación con tarea
            $table->timestamps();
    
            // Llaves foráneas
            $table->foreign('id_student')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_task')->references('id')->on('tasks')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

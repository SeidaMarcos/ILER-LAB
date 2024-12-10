<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_request', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->text('comment');
            $table->enum('status', ['new', 'work in progress', 'completed']);
            $table->foreignId('created_by_professor')->constrained('professors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_request');
    }
};

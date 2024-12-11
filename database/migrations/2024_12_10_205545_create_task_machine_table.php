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
        Schema::create('task_machine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_task')->constrained('tasks');
            $table->foreignId('id_machine')->constrained('machines');
            $table->unique(['id_task', 'id_machine']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_machines');
    }
};

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
        Schema::create('task_tool', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_task')->constrained('tasks');
            $table->foreignId('id_tool')->constrained('tools');
            $table->unique(['id_task', 'id_tool']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_tools');
    }
};

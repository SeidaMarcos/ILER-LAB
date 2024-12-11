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
        Schema::create('task_product', function (Blueprint $table) {
            $table->foreignId('id_task')->constrained('tasks');
            $table->foreignId('id_product')->constrained('products');
            $table->unique(['id_task', 'id_product']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_products');
    }
};

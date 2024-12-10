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
        Schema::create('groups_studennt', function (Blueprint $table) {
            $table->foreignId('id_group')->constrained('groups');
            $table->foreignId('id_student')->constrained('students');
            $table->unique(['id_group', 'id_student']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups_studennt');
    }
};

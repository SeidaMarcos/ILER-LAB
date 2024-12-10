<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['student', 'professor']);
            $table->enum('ciclo', ['anatomia', 'laboratorio'])->nullable();
            $table->enum('curso', ['1º', '2º'])->nullable();
            $table->foreignId('approved_by_admin')->nullable()->constrained('admins');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_registrations');
    }
};


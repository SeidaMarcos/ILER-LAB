<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessorsTable extends Migration
{
    public function up()
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con users
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('professors');
    }
}

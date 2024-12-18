<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTable extends Migration
{
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // Referencia única
            $table->string('name');
            $table->integer('stock')->unsigned(); // Stock no negativo
            $table->enum('material', ['vidrio', 'madera', 'plástico']); // Enum de materiales
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tools');
    }
}

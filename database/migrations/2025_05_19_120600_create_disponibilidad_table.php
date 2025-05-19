<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisponibilidadTable extends Migration
{
    public function up()
    {
        Schema::create('disponibilidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->boolean('disponible')->default(true);
            $table->timestamps();

            $table->foreign('empresa_id')
                  ->references('id')
                  ->on('empresas')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('disponibilidad');
    }
}

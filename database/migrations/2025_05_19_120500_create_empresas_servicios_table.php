<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasServiciosTable extends Migration
{
    public function up()
    {
        Schema::create('empresas_servicios', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('servicio_id');
            $table->primary(['empresa_id', 'servicio_id']);

            $table->foreign('empresa_id')
                  ->references('id')
                  ->on('empresas')
                  ->onDelete('cascade');

            $table->foreign('servicio_id')
                  ->references('id')
                  ->on('servicios')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas_servicios');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalzadoHasNumeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calzado_has_numero', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id_calzado_chn');
            $table->unsignedBigInteger('id_numero_chn');       
            $table->integer('existencias');
            
            $table->foreign('id_calzado_chn')->references('id_calzado')->on('calzado');
            $table->foreign('id_numero_chn')->references('id_numero')->on('numero');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calzado_has_numero');
    }
}

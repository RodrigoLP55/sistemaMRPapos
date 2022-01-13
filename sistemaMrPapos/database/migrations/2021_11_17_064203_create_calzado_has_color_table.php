<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalzadoHasColorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calzado_has_color', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id_calzado_chc');
            $table->unsignedBigInteger('id_color_chc');
            
            $table->foreign('id_calzado_chc')->references('id_calzado')->on('calzado');
            $table->foreign('id_color_chc')->references('id_color')->on('color');
            
       
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calzado_has_color');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalzadoHasProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calzado_has_proveedor', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id_calzado_chp');
            $table->unsignedBigInteger('id_proveedor_chp');
            
            $table->foreign('id_calzado_chp')->references('id_calzado')->on('calzado');
            $table->foreign('id_proveedor_chp')->references('rfc')->on('proveedor');
            
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calzado_has_proveedor');
    }
}

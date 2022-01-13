<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucion', function (Blueprint $table) {
            $table->id('id_devolucion');
            
            $table->unsignedBigInteger('id_venta_d');
            $table->unsignedBigInteger('id_detalle_venta_d');
            $table->unsignedBigInteger('id_calzado_d');
            
            $table->integer('numero_d');
            $table->datetime('fecha_devo');
            $table->string('motivo', 50);
            
            $table->foreign('id_venta_d')->references('id_venta')->on('venta');
            $table->foreign('id_detalle_venta_d')->references('id_detalle_venta')->on('detalle_venta');
            $table->foreign('id_calzado_d')->references('id_calzado')->on('calzado');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devolucion');
    }
}

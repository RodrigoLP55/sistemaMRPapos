<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->id('id_detalle_venta');
            
            $table->unsignedBigInteger('id_venta_dv');
            $table->unsignedBigInteger('id_calzado_dv');
            
            $table->integer('numero_dv');
            $table->integer('cant_dv');

            $table->doulble('precio_uni', 8,2);

            $table->doulble('subtotal', 8,2);

            $table->foreign('id_venta_dv')->references('id_venta')->on('venta');
            $table->foreign('id_calzado_dv')->references('id_calzado')->on('calzado');
            
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
        Schema::dropIfExists('detalle_venta');
    }
}

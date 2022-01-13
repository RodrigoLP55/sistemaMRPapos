<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->id('id_detalle_pedido');
            
            $table->unsignedBigInteger('id_pedido_dp');
            $table->unsignedBigInteger('id_calzado_dp');
            
            $table->integer('numero');
            $table->integer('cant_dp');
            
            $table->doulble('precio_uni', 8,2);

            $table->doulble('subtotal', 8,2);

            $table->foreign('id_pedido_dp')->references('id_pedido')->on('pedido');
            $table->foreign('id_calzado_dp')->references('id_calzado')->on('calzado');
            
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
        Schema::dropIfExists('detalle_pedido');
    }
}

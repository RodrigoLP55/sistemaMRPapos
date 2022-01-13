<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->id('id_pedido');
            
            $table->unsignedBigInteger('id_user_p');
            $table->unsignedBigInteger('id_proveedor_p');
            
            $table->datetime('fecha_hora')->nulleable();
            $table->double('total_p')->nulleable();
            
            $table->foreign('id_user_p')->references('id')->on('users');
            $table->foreign('id_proveedor_p')->references('rfc')->on('proveedor');
            
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
        Schema::dropIfExists('pedido');
    }
}

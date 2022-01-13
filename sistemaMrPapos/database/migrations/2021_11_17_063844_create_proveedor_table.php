<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id('rfc');
            $table->string('razon_social');
            $table->string('email');
            
            $table->unsignedBigInteger('id_telefono_p');
            $table->foreign('id_telefono_p')->references('id_telefono')->on('telefono');
            $table->unsignedBigInteger('id_direccion_p');
            $table->foreign('id_direccion_p')->references('id_direccion')->on('direccion');
            
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
        Schema::dropIfExists('proveedor');
    }
}

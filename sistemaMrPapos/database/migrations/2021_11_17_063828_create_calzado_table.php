<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalzadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calzado', function (Blueprint $table) {
            $table->id('id_calzado');
            $table->string('marca', 30);
            $table->string('modelo', 30);
            $table->double('precio_v', 8, 2);
            $table->double('precio_c', 8, 2);
            
            $table->unsignedBigInteger('id_tipo_c');
            $table->foreign('id_tipo_c')->references('id_tipo_calzado')->on('tipo_calzado');
            
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
        Schema::dropIfExists('calzado');
    }
}

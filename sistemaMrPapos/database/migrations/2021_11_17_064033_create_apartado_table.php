<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartado', function (Blueprint $table) {
            $table->id('id_apartado');
     
            $table->unsignedBigInteger('id_user_a');
            $table->unsignedBigInteger('id_calzado_a');
        
            $table->integer('numero_a');
            $table->double('anticipo', 8, 2);
            $table->dateTime('fecha_apartado');
            $table->dateTime('fecha_liquidacion')->nullable();
            $table->integer('estado');  /**Estado -> LIQUIDADO - 1  ,  NO LIQUIDADO - 0 */
   
            $table->foreign('id_user_a')->references('id')->on('users');
            $table->foreign('id_calzado_a')->references('id_calzado')->on('calzado');
   
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
        Schema::dropIfExists('apartado');
    }
}

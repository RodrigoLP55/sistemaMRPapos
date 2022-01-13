<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDireecionTelefonoToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            //
            $table->unsignedBigInteger('telefono_u');
            $table->foreign('telefono_u')->references('id_telefono')->on('telefono');
            $table->unsignedBigInteger('direccion_u');
            $table->foreign('direccion_u')->references('id_direccion')->on('direccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}

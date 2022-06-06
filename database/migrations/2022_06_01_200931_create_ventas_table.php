<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_celular');
            $table->string('nombre_cliente')->nullable(false);
            $table->string('numero_celular_cliente')->nullable(false);
            $table->string('imei')->nullable(false);
            $table->integer('cc_cliente')->unsigned()->nullable(false);
            $table->date('fecha')->nullable(false);

            // FK
            $table->foreign('id_celular')->references('id')->on('celulares')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}

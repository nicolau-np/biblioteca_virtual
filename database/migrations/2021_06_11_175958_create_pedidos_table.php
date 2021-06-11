<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_leitor')->unsigned()->index();
            $table->bigInteger('id_tipo_pedido')->unsigned()->index();
            $table->string('estado');
            $table->timestamps();
        });

        Schema::table('pedidos', function(Blueprint $table){
            $table->foreign('id_leitor')->references('id')->on('leitors')->onUpdate('cascade');
            $table->foreign('id_tipo_pedido')->references('id')->on('tipo_pedidos')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
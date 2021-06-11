<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_autor')->unsigned()->index();
            $table->bigInteger('id_editora')->unsigned()->index();
            $table->bigInteger('id_categoria_livro')->unsigned()->index();
            $table->string('titulo');
            $table->text('foto_capa')->nullable();
            $table->date('data_lancamento')->nullable();
            $table->string('estado');
            $table->timestamps();
        });

        Schema::table('livros', function (Blueprint $table) {
            $table->foreign('id_autor')->references('id')->on('autors')->onUpdate('cascade');
            $table->foreign('id_editora')->references('id')->on('editoras')->onUpdate('cascade');
            $table->foreign('id_categoria_livro')->references('id')->on('categoria_livros')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livros');
    }
}
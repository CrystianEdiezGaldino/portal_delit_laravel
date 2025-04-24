<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewConteudosIeadTable extends Migration
{
    public function up()
    {
        Schema::create('conteudos_iead', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->integer('grau');
            $table->string('tipo_conteudo');
            $table->string('caminho_arquivo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conteudos_iead');
    }
}
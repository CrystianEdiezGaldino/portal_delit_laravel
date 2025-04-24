<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePkUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pk_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('ime_num');
            $table->string('cadastro');
            $table->string('cic')->nullable();
            $table->string('email')->nullable();
            $table->string('pai')->nullable();
            $table->string('mae')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('cidade1')->nullable();
            $table->string('estado1')->nullable();
            $table->string('nacionalidade')->nullable();
            $table->string('profissao')->nullable();
            $table->string('endereco_residencial')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('cep')->nullable();
            $table->string('telefone_residencial')->nullable();
            $table->string('telefone_comercial')->nullable();
            $table->string('celular')->nullable();
            $table->string('estado_civil')->nullable();
            $table->integer('numero_filhos')->nullable();
            $table->boolean('sexo_m')->default(false);
            $table->boolean('sexo_f')->default(false);
            $table->string('esposa')->nullable();
            $table->date('nascida')->nullable();
            $table->date('casamento')->nullable();
            $table->integer('ativo_no_grau')->default(1);
            $table->timestamps();

            $table->foreign('ime_num')->references('ime')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pk_usuarios');
    }
} 
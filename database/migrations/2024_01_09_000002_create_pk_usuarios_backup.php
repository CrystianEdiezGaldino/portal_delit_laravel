<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePkUsuariosBackup extends Migration
{
    public function up()
    {
        // First create the backup table with the same structure
        Schema::create('pk_usuarios_backup', function (Blueprint $table) {
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
        });

        // Copy all data from pk_usuarios to pk_usuarios_backup
        DB::statement('INSERT INTO pk_usuarios_backup SELECT * FROM pk_usuarios');
    }

    public function down()
    {
        Schema::dropIfExists('pk_usuarios_backup');
    }
}
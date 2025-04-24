<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PopulatePkUsuariosTable extends Migration
{
    public function up()
    {
        // Lê o arquivo CSV
        $file = fopen(base_path('csv tb2.csv'), 'r');
        
        // Pula a primeira linha (cabeçalho)
        fgetcsv($file);

        // Processa cada linha
        while (($line = fgetcsv($file)) !== FALSE) {
            DB::table('pk_usuarios')->insert([
                'id' => $line[0], // ID Registro
                'ime' => $line[1], // IME nº
                'nome' => $line[2], // cadastro/nome
                'email' => $line[3], // email
                'pai' => $line[4], // pai
                'mae' => $line[5], // mãe
                'nascimento' => !empty($line[6]) ? date('Y-m-d', strtotime(str_replace('.', '-', $line[6]))) : null, // nascimento
                'cidade' => $line[7], // cidade1
                'estado' => $line[8], // estado1
                'nacionalidade' => $line[9], // nacionalidade
                'profissao' => $line[10], // profissão
                'endereco' => $line[11], // endRes
                'bairro' => $line[12], // bairro
                'cidade_atual' => $line[13], // cidade
                'estado_atual' => $line[14], // estado
                'cep' => $line[15], // cep
                'telefone' => $line[16], // foneRes
                'telefone_comercial' => $line[17], // foneCom
                'celular' => $line[18], // cellular
                'estado_civil' => $line[19], // estadoCivil
                'num_filhos' => $line[20], // nºFilhos
                'filhos_m' => $line[21], // M
                'filhos_f' => $line[22], // F
                'conjuge' => $line[23], // esposa
                'data_casamento' => !empty($line[25]) ? date('Y-m-d', strtotime(str_replace('.', '-', $line[25]))) : null, // casamento
                'rg' => $line[26], // RG
                'orgao_expedidor' => $line[27], // orgãoExpedidor
                'cpf' => $line[28], // cic
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        fclose($file);
    }

    public function down()
    {
        DB::table('pk_usuarios')->truncate();
    }
}
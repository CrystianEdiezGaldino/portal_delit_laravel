<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FixCaminhoArquivosController extends Controller
{
    public function migrarArquivos()
    {
        $conteudos = DB::table('conteudos_iead')->get();
        $contador = 0;
        
        foreach ($conteudos as $conteudo) {
            $caminhoAntigo = $conteudo->caminho_arquivo;
            
            // Verifica se o caminho começa com /storage
            if (strpos($caminhoAntigo, '/storage/') === 0) {
                // Pega apenas o nome do arquivo do caminho antigo
                $nomeArquivo = basename($caminhoAntigo);
                
                // Cria o novo caminho no formato /uploads/iead/nome_do_arquivo
                $novoCaminho = '/uploads/iead/' . $nomeArquivo;
                
                // Atualiza no banco de dados
                DB::table('conteudos_iead')
                    ->where('id', $conteudo->id)
                    ->update(['caminho_arquivo' => $novoCaminho]);
                
                $contador++;
            }
        }
        
        return "Migração concluída! $contador registros atualizados.";
    }
} 
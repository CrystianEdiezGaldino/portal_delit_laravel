<?php

namespace App\Services;

use App\Models\ConteudoIead;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ConteudoIeadService
{
    protected $conteudo;

    public function __construct(ConteudoIead $conteudo)
    {
        $this->conteudo = $conteudo;
    }

    public function criarConteudo($dados, $arquivo)
    {
        try {
            DB::beginTransaction();

            $path = $arquivo->store('public/uploads/iead');
            
            $conteudo = $this->conteudo->create([
                'titulo' => $dados['titulo'],
                'descricao' => $dados['descricao'],
                'grau' => $dados['grau'],
                'tipo_conteudo' => $dados['tipo_conteudo'],
                'caminho_arquivo' => Storage::url($path)
            ]);

            DB::commit();
            return $conteudo;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarConteudo($id, $dados, $arquivo = null)
    {
        try {
            DB::beginTransaction();

            $conteudo = $this->conteudo->findOrFail($id);
            $dadosAtualizados = $dados;

            if ($arquivo) {
                // Remove arquivo antigo
                $caminhoAntigo = str_replace('storage/', 'public/', $conteudo->caminho_arquivo);
                Storage::delete($caminhoAntigo);

                // Salva novo arquivo
                $path = $arquivo->store('public/uploads/iead');
                $dadosAtualizados['caminho_arquivo'] = Storage::url($path);
            }

            $conteudo->update($dadosAtualizados);

            DB::commit();
            return $conteudo;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletarConteudo($id)
    {
        try {
            DB::beginTransaction();

            $conteudo = $this->conteudo->findOrFail($id);
            
            // Remove arquivo
            $caminho = str_replace('storage/', 'public/', $conteudo->caminho_arquivo);
            Storage::delete($caminho);
            
            $conteudo->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function listarConteudos($grau = null)
    {
        $query = $this->conteudo->query();

        if ($grau) {
            $query->where('grau', $grau);
        }

        return $query->orderBy('grau', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function verificarAcesso($id, $grauUsuario)
    {
        $conteudo = $this->conteudo->findOrFail($id);
        return $grauUsuario >= $conteudo->grau;
    }
} 
<?php

namespace App\Services;

use App\Models\Planilha;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PlanilhaService
{
    protected $planilha;

    public function __construct(Planilha $planilha)
    {
        $this->planilha = $planilha;
    }

    public function criarPlanilha($dados, $arquivo)
    {
        try {
            DB::beginTransaction();

            $path = $arquivo->store('public/uploads/planilhas');
            
            $planilha = $this->planilha->create([
                'nome' => $dados['nome'],
                'caminho' => Storage::url($path),
                'grau_acesso' => $dados['grau_acesso']
            ]);

            DB::commit();
            return $planilha;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarPlanilha($id, $dados, $arquivo = null)
    {
        try {
            DB::beginTransaction();

            $planilha = $this->planilha->findOrFail($id);
            $dadosAtualizados = $dados;

            if ($arquivo) {
                // Remove arquivo antigo
                $caminhoAntigo = str_replace('storage/', 'public/', $planilha->caminho);
                Storage::delete($caminhoAntigo);

                // Salva novo arquivo
                $path = $arquivo->store('public/uploads/planilhas');
                $dadosAtualizados['caminho'] = Storage::url($path);
            }

            $planilha->update($dadosAtualizados);

            DB::commit();
            return $planilha;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletarPlanilha($id)
    {
        try {
            DB::beginTransaction();

            $planilha = $this->planilha->findOrFail($id);
            
            // Remove arquivo
            $caminho = str_replace('storage/', 'public/', $planilha->caminho);
            Storage::delete($caminho);
            
            $planilha->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function listarPlanilhas($grauUsuario = null)
    {
        $query = $this->planilha->query();

        if ($grauUsuario) {
            $query->where('grau_acesso', '<=', $grauUsuario);
        }

        return $query->orderBy('grau_acesso', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function verificarAcesso($id, $grauUsuario)
    {
        $planilha = $this->planilha->findOrFail($id);
        return $grauUsuario >= $planilha->grau_acesso;
    }
} 
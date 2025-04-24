<?php

namespace App\Services;

use App\Models\Chamado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChamadoService
{
    protected $chamado;

    public function __construct(Chamado $chamado)
    {
        $this->chamado = $chamado;
    }

    public function criarChamado($dados)
    {
        try {
            DB::beginTransaction();

            $chamado = $this->chamado->create([
                'usuario_ime' => Auth::user()->ime,
                'titulo' => $dados['titulo'],
                'descricao' => $dados['descricao'],
                'prioridade' => $dados['prioridade'],
                'status' => 'aberto',
                'data_abertura' => now()
            ]);

            DB::commit();
            return $chamado;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atenderChamado($id)
    {
        try {
            DB::beginTransaction();

            $chamado = $this->chamado->findOrFail($id);
            
            if ($chamado->status !== 'aberto') {
                throw new \Exception('Este chamado já está ' . $chamado->status);
            }

            $chamado->update([
                'atendente_ime' => Auth::user()->ime,
                'status' => 'em andamento',
                'data_atendimento' => now()
            ]);

            DB::commit();
            return $chamado;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function concluirChamado($id)
    {
        try {
            DB::beginTransaction();

            $chamado = $this->chamado->findOrFail($id);
            
            if ($chamado->status !== 'em andamento') {
                throw new \Exception('Este chamado precisa estar em andamento para ser concluído');
            }

            if ($chamado->atendente_ime != Auth::user()->ime && Auth::user()->role != 'admin') {
                throw new \Exception('Apenas o atendente responsável pode concluir este chamado');
            }

            $chamado->update([
                'status' => 'resolvido',
                'data_fechamento' => now()
            ]);

            DB::commit();
            return $chamado;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function listarChamados($filtros = [])
    {
        $query = $this->chamado->query();

        if (!empty($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        if (!empty($filtros['prioridade'])) {
            $query->where('prioridade', $filtros['prioridade']);
        }

        if (!empty($filtros['search'])) {
            $query->where(function($q) use ($filtros) {
                $q->where('titulo', 'like', "%{$filtros['search']}%")
                  ->orWhere('descricao', 'like', "%{$filtros['search']}%");
            });
        }

        if (!empty($filtros['usuario_ime'])) {
            $query->where('usuario_ime', $filtros['usuario_ime']);
        }

        return $query->orderBy('status', 'ASC')
                    ->orderBy('data_abertura', 'DESC')
                    ->paginate(15);
    }

    public function meusChamados()
    {
        return $this->chamado->where('usuario_ime', Auth::user()->ime)
                            ->orderBy('status', 'ASC')
                            ->orderBy('data_abertura', 'DESC')
                            ->get();
    }
} 
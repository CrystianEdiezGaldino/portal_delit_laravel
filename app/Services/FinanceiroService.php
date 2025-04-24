<?php

namespace App\Services;

use App\Models\Financeiro;
use Illuminate\Support\Facades\DB;

class FinanceiroService
{
    protected $financeiro;

    public function __construct(Financeiro $financeiro)
    {
        $this->financeiro = $financeiro;
    }

    public function criarRegistro($dados)
    {
        try {
            DB::beginTransaction();

            $registro = $this->financeiro->create([
                'usuario_ime' => $dados['usuario_ime'],
                'tipo' => $dados['tipo'],
                'valor' => $dados['valor'],
                'descricao' => $dados['descricao'],
                'data' => $dados['data'] ?? now(),
                'status' => $dados['status'] ?? 'pendente'
            ]);

            DB::commit();
            return $registro;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarRegistro($id, $dados)
    {
        try {
            DB::beginTransaction();

            $registro = $this->financeiro->findOrFail($id);
            $registro->update($dados);

            DB::commit();
            return $registro;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletarRegistro($id)
    {
        try {
            DB::beginTransaction();

            $registro = $this->financeiro->findOrFail($id);
            $registro->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function listarRegistros($filtros = [])
    {
        $query = $this->financeiro->query();

        if (!empty($filtros['usuario_ime'])) {
            $query->where('usuario_ime', $filtros['usuario_ime']);
        }

        if (!empty($filtros['tipo'])) {
            $query->where('tipo', $filtros['tipo']);
        }

        if (!empty($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        if (!empty($filtros['data_inicio'])) {
            $query->where('data', '>=', $filtros['data_inicio']);
        }

        if (!empty($filtros['data_fim'])) {
            $query->where('data', '<=', $filtros['data_fim']);
        }

        return $query->orderBy('data', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
    }

    public function calcularSaldo($usuarioIme)
    {
        $entradas = $this->financeiro->where('usuario_ime', $usuarioIme)
                                    ->where('tipo', 'entrada')
                                    ->where('status', 'pago')
                                    ->sum('valor');

        $saidas = $this->financeiro->where('usuario_ime', $usuarioIme)
                                  ->where('tipo', 'saida')
                                  ->where('status', 'pago')
                                  ->sum('valor');

        return $entradas - $saidas;
    }

    public function gerarRelatorio($filtros = [])
    {
        $query = $this->financeiro->query();

        if (!empty($filtros['usuario_ime'])) {
            $query->where('usuario_ime', $filtros['usuario_ime']);
        }

        if (!empty($filtros['tipo'])) {
            $query->where('tipo', $filtros['tipo']);
        }

        if (!empty($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        if (!empty($filtros['data_inicio'])) {
            $query->where('data', '>=', $filtros['data_inicio']);
        }

        if (!empty($filtros['data_fim'])) {
            $query->where('data', '<=', $filtros['data_fim']);
        }

        return $query->orderBy('data', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->get();
    }
} 
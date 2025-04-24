<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Financeiro extends Model
{
    protected $table = 'financeiro';

    protected $fillable = [
        'usuario_ime',
        'tipo',
        'valor',
        'descricao',
        'data',
        'status'
    ];

    protected $dates = [
        'data'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_ime', 'ime');
    }

    public function scopeEntradas($query)
    {
        return $query->where('tipo', 'entrada');
    }

    public function scopeSaidas($query)
    {
        return $query->where('tipo', 'saida');
    }

    public function scopePagos($query)
    {
        return $query->where('status', 'pago');
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeCancelados($query)
    {
        return $query->where('status', 'cancelado');
    }

    // Definindo a conexão (opcional, se não for a padrão)
    protected $connection = 'mysql';
    
    // Como não usaremos uma tabela única para o modelo, não definimos $table
    
    // Funções para Taxas
    public function cadastrarTaxa(array $dados): bool
    {
        return DB::table('taxas')->insert($dados);
    }
    
    public function listarTaxas(?string $status = null): array
    {
        $query = DB::table('taxas')
            ->select('*');
            
        if ($status !== null) {
            $query->where('status', $status);
        }
        
        return $query->orderBy('nome', 'ASC')
            ->get()
            ->toArray();
    }
    
    public function getTaxa(int $id): ?object
    {
        return DB::table('taxas')->where('id', $id)->first();
    }
    
    public function salvarTaxa(array $dados): bool
    {
        if (isset($dados['id'])) {
            return DB::table('taxas')
                ->where('id', $dados['id'])
                ->update($dados);
        } else {
            return DB::table('taxas')->insert($dados);
        }
    }
    
    public function deletarTaxa(int $id): int
    {
        return DB::table('taxas')->where('id', $id)->delete();
    }
    
    // Funções para Recibos
    public function gerarRecibo(array $dados): ?int
    {
        try {
            // Format valor_pago
            $valor_pago = str_replace(['.', ','], ['', '.'], $dados['valor_pago']);
            
            // Prepare recibo data
            $dados_recibo = [
                'ime' => $dados['ime'],
                'valor_pago' => $valor_pago,
                'forma_pagamento' => $dados['forma_pagamento'],
                'meio_pagamento' => $dados['meio_pagamento'],
                'data_pagamento' => now(),
                'recebido_por' => Auth::user()->nome,
                'numero_transacao' => $dados['numero_transacao'] ?? null,
                'status_pagamento' => 'confirmado',
                'tipo_recibo' => $dados['tipo_recibo'],
                'descricao' => $dados['descricao'],
                'taxa_id' => !empty($dados['taxa_id']) ? $dados['taxa_id'] : null
            ];
    
            // Usando transação do Laravel
            return DB::transaction(function () use ($dados_recibo, $valor_pago, $dados) {
                // Insert recibo
                $recibo_id = DB::table('recibos')->insertGetId($dados_recibo);
    
                // Register in caixa
                $dados_caixa = [
                    'descricao' => $dados['descricao'] ?: 'Recibo #' . $recibo_id,
                    'tipo' => 'entrada',
                    'valor' => $valor_pago,
                    'categoria' => $dados['tipo_recibo'],
                    'recibo_id' => $recibo_id,
                    'ime_responsavel' => Auth::user()->ime,
                    'data_movimentacao' => now()
                ];
    
                DB::table('caixa')->insert($dados_caixa);
                
                return $recibo_id;
            });
    
        } catch (\Exception $e) {
            Log::error('Erro ao gerar recibo: ' . $e->getMessage());
            return null;
        }
    }
    
    public function listarRecibos(array $filtros = []): array
    {
        $query = DB::table('recibos as r')
            ->select('r.*', 't.nome as taxa_nome', 'u.nome as nome_usuario')
            ->leftJoin('taxas as t', 't.id', '=', 'r.taxa_id')
            ->leftJoin('usuarios as u', 'u.ime', '=', 'r.ime');
        
        if (!empty($filtros['status'])) {
            $query->where('r.status_pagamento', $filtros['status']);
        }
        
        if (!empty($filtros['data_inicio'])) {
            $query->whereDate('r.data_pagamento', '>=', $filtros['data_inicio']);
        }
        
        if (!empty($filtros['data_fim'])) {
            $query->whereDate('r.data_pagamento', '<=', $filtros['data_fim']);
        }
        
        return $query->orderBy('r.data_pagamento', 'DESC')
            ->get()
            ->toArray();
    }
    
    public function obterRecibo(int $id): ?array
    {
        $result = DB::table('recibos as r')
            ->select('r.*', 't.nome as taxa_nome', 'u.nome as nome_usuario', 'u.email')
            ->leftJoin('taxas as t', 't.id', '=', 'r.taxa_id')
            ->leftJoin('usuarios as u', 'u.ime', '=', 'r.ime')
            ->where('r.id', $id)
            ->first();
        return $result ? (array) $result : null;
    }
    
    public function confirmarPagamento(int $id): int
    {
        return DB::table('recibos')
            ->where('id', $id)
            ->update([
                'status_pagamento' => 'confirmado',
                'data_confirmacao' => now()
            ]);
    }
    
    // Relatórios
    public function relatorioRecebimentos(string $data_inicio, string $data_fim): array
    {
        return DB::table('recibos')
            ->select(DB::raw('SUM(valor_pago) as total, tipo_recibo, COUNT(*) as quantidade'))
            ->where('data_pagamento', '>=', $data_inicio)
            ->where('data_pagamento', '<=', $data_fim)
            ->where('status_pagamento', 'confirmado')
            ->groupBy('tipo_recibo')
            ->get()
            ->toArray();
    }

    // Método para verificar se existem dados nas tabelas principais
    public function verificarDadosIniciais(): array
    {
        return [
            'taxas' => DB::table('taxas')->count() > 0,
            'recibos' => DB::table('recibos')->count() > 0,
            'caixa' => DB::table('caixa')->count() > 0
        ];
    }

    // Método para Dashboard
    public function obterDadosDashboard(): array
    {
        $hoje = now()->format('Y-m-d');
        $mes_atual = now()->format('Y-m');
        
        return [
            'total_recibos' => DB::table('recibos')->count(),
            'recibos_pendentes' => DB::table('recibos')->where('status_pagamento', 'pendente')->count(),
            'receita_mes' => DB::table('recibos')
                ->where(DB::raw("DATE_FORMAT(data_pagamento, '%Y-%m')"), $mes_atual)
                ->where('status_pagamento', 'confirmado')
                ->sum('valor_pago') ?? 0,
            'receita_hoje' => DB::table('recibos')
                ->whereDate('data_pagamento', $hoje)
                ->where('status_pagamento', 'confirmado')
                ->sum('valor_pago') ?? 0
        ];
    }

    // Método para Relatórios
    public function gerarRelatorio(string $tipo, array $filtros = []): array
    {
        switch ($tipo) {
            case 'receitas':
                return $this->relatorioReceitas($filtros);
            case 'taxas':
                return $this->relatorioTaxas($filtros);
            default:
                return [];
        }
    }

    private function relatorioReceitas(array $filtros): array
    {
        $query = DB::table('recibos')
            ->select(DB::raw('DATE(data_pagamento) as data, SUM(valor_pago) as total'))
            ->where('status_pagamento', 'confirmado');
            
        if (!empty($filtros['data_inicio'])) {
            $query->where('data_pagamento', '>=', $filtros['data_inicio']);
        }
        
        if (!empty($filtros['data_fim'])) {
            $query->where('data_pagamento', '<=', $filtros['data_fim']);
        }
        
        return $query->groupBy(DB::raw('DATE(data_pagamento)'))
            ->orderBy('data_pagamento', 'DESC')
            ->get()
            ->toArray();
    }

    private function relatorioTaxas(array $filtros): array
    {
        return DB::table('taxas as t')
            ->select('t.nome', DB::raw('COUNT(r.id) as quantidade, SUM(r.valor_pago) as total'))
            ->leftJoin('recibos as r', 'r.taxa_id', '=', 't.id')
            ->where('r.status_pagamento', 'confirmado')
            ->groupBy('t.id')
            ->get()
            ->toArray();
    }

    public function obterRecibosRecentes(int $limite = 5): array
    {
        return DB::table('recibos as r')
            ->select('r.*', 'u.nome as nome_usuario')
            ->leftJoin('usuarios as u', 'u.ime', '=', 'r.ime')
            ->orderBy('r.data_pagamento', 'DESC')
            ->limit($limite)
            ->get()
            ->toArray();
    }

    public function buscarMembroPorIme(string $ime): ?array
    {
        $resultado = DB::table('usuarios')
            ->select('ime', 'nome', 'email')
            ->where('ime', $ime)
            ->first();
            
        return $resultado ? (array)$resultado : null;
    }

    public function validarRecibo(array $dados): array
    {
        try {
            // Campos obrigatórios
            $campos_obrigatorios = [
                'ime' => 'IME',
                'valor_pago' => 'Valor',
                'forma_pagamento' => 'Forma de Pagamento',
                'meio_pagamento' => 'Meio de Pagamento',
                'tipo_recibo' => 'Tipo de Recibo'
            ];

            foreach ($campos_obrigatorios as $campo => $nome) {
                if (!isset($dados[$campo]) || $dados[$campo] === '') {
                    return ['status' => false, 'mensagem' => "Campo {$nome} é obrigatório"];
                }
            }

            // Verifica se o valor é válido
            if (!is_numeric($dados['valor_pago']) || $dados['valor_pago'] <= 0) {
                return ['status' => false, 'mensagem' => 'Valor inválido'];
            }

            // Verifica se o membro existe
            $membro = $this->buscarMembroPorIme($dados['ime']);
            if (!$membro) {
                return ['status' => false, 'mensagem' => 'Membro não encontrado'];
            }

            return ['status' => true, 'mensagem' => 'Dados válidos'];

        } catch (\Exception $e) {
            Log::error('Exceção na validação do recibo: ' . $e->getMessage());
            return ['status' => false, 'mensagem' => 'Erro ao validar dados'];
        }
    }

    public function inserirRecibo(array $dados): ?int
    {
        try {
            // Validação básica
            if (empty($dados['ime']) || empty($dados['valor_pago']) || 
                empty($dados['forma_pagamento']) || empty($dados['tipo_recibo'])) {
                Log::error('Dados incompletos para inserir recibo');
                return null;
            }

            // Garante que todos os campos necessários estão presentes
            $dados_insert = [
                'ime' => $dados['ime'],
                'valor_pago' => $dados['valor_pago'],
                'forma_pagamento' => $dados['forma_pagamento'],
                'data_pagamento' => $dados['data_pagamento'] ?? now(),
                'recebido_por' => $dados['recebido_por'] ?? Auth::user()->nome,
                'meio_pagamento' => $dados['meio_pagamento'],
                'numero_transacao' => $dados['numero_transacao'] ?? null,
                'status_pagamento' => $dados['status_pagamento'] ?? 'confirmado',
                'tipo_recibo' => $dados['tipo_recibo'],
                'descricao' => $dados['descricao'] ?? '',
                'taxa_id' => $dados['taxa_id'] ?? null
            ];

            return DB::table('recibos')->insertGetId($dados_insert);

        } catch (\Exception $e) {
            Log::error('Exceção ao inserir recibo: ' . $e->getMessage());
            return null;
        }
    }

    public function inserirCaixa(array $dados): bool
    {
        try {
            // Log para debug
            Log::debug('Tentando inserir registro no caixa: ' . json_encode($dados));

            // Validação dos campos obrigatórios
            $campos_obrigatorios = ['descricao', 'tipo', 'valor', 'categoria', 'recibo_id', 'ime_responsavel'];
            foreach ($campos_obrigatorios as $campo) {
                if (empty($dados[$campo])) {
                    Log::error('Campo obrigatório ausente no caixa: ' . $campo);
                    return false;
                }
            }

            // Validação do valor
            if (!is_numeric($dados['valor']) || $dados['valor'] <= 0) {
                Log::error('Valor inválido para o caixa: ' . $dados['valor']);
                return false;
            }

            // Garante que a data de registro está presente
            if (empty($dados['data_registro'])) {
                $dados['data_registro'] = now();
            }

            // Insere no caixa
            return DB::table('caixa')->insert($dados);

        } catch (\Exception $e) {
            Log::error('Exceção ao inserir no caixa: ' . $e->getMessage());
            return false;
        }
    }

    public function obterUltimoNumeroTransacao(string $forma_pagamento): ?string
    {
        try {
            return DB::table('recibos')
                ->where('forma_pagamento', $forma_pagamento)
                ->orderBy('id', 'DESC')
                ->value('numero_transacao');
        } catch (\Exception $e) {
            Log::error('Erro ao obter último número de transação: ' . $e->getMessage());
            return null;
        }
    }
}
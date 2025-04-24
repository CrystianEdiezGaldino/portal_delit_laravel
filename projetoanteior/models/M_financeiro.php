<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_financeiro extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Funções para Taxas
    public function cadastrar_taxa($dados) {
        return $this->db->insert('taxas', $dados);
    }
    
    public function listar_taxas($status = null) {
        $this->db->select('*');
        $this->db->from('taxas');
        
        if ($status !== null) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('nome', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array(); // Changed from result() to result_array()
    }
    
    public function get_taxa($id) {
        return $this->db->get_where('taxas', ['id' => $id])->row();
    }
    
    public function salvar_taxa($dados) {
        if (isset($dados['id'])) {
            $this->db->where('id', $dados['id']);
            return $this->db->update('taxas', $dados);
        } else {
            return $this->db->insert('taxas', $dados);
        }
    }
    
    public function deletar_taxa($id) {
        return $this->db->delete('taxas', ['id' => $id]);
    }
    
    // Funções para Recibos
    public function gerar_recibo($dados) {
        try {
            // Format valor_pago
            $valor_pago = str_replace(['.', ','], ['', '.'], $dados['valor_pago']);
            
            // Prepare recibo data
            $dados_recibo = [
                'ime' => $dados['ime'],
                'valor_pago' => $valor_pago,
                'forma_pagamento' => $dados['forma_pagamento'],
                'meio_pagamento' => $dados['meio_pagamento'],
                'data_pagamento' => date('Y-m-d H:i:s'),
                'recebido_por' => $this->session->userdata('user_data')['nome'],
                'numero_transacao' => $dados['numero_transacao'] ?? null,
                'status_pagamento' => 'confirmado',
                'tipo_recibo' => $dados['tipo_recibo'],
                'descricao' => $dados['descricao'],
                'taxa_id' => !empty($dados['taxa_id']) ? $dados['taxa_id'] : null
            ];
    
            // Insert recibo
            $this->db->trans_begin();
            $this->db->insert('recibos', $dados_recibo);
            $recibo_id = $this->db->insert_id();
    
            // Register in caixa
            $dados_caixa = [
                'descricao' => $dados['descricao'] ?: 'Recibo #' . $recibo_id,
                'tipo' => 'entrada',
                'valor' => $valor_pago,
                'categoria' => $dados['tipo_recibo'],
                'recibo_id' => $recibo_id,
                'ime_responsavel' => $this->session->userdata('user_data')['ime'],
                'data_movimentacao' => date('Y-m-d H:i:s')
            ];
    
            $this->db->insert('caixa', $dados_caixa);
    
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            }
    
            $this->db->trans_commit();
            return $recibo_id;
    
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Erro ao gerar recibo: ' . $e->getMessage());
            return false;
        }
    }
    
    public function listar_recibos($filtros = []) {
        $this->db->select('r.*, t.nome as taxa_nome, u.nome as nome_usuario');
        $this->db->from('recibos r');
        $this->db->join('taxas t', 't.id = r.taxa_id', 'left');
        $this->db->join('usuarios u', 'u.ime = r.ime', 'left');
        
        if (!empty($filtros['status'])) {
            $this->db->where('r.status_pagamento', $filtros['status']);
        }
        if (!empty($filtros['data_inicio'])) {
            $this->db->where('DATE(r.data_pagamento) >=', $filtros['data_inicio']);
        }
        if (!empty($filtros['data_fim'])) {
            $this->db->where('DATE(r.data_pagamento) <=', $filtros['data_fim']);
        }
        
        $this->db->order_by('r.data_pagamento', 'DESC');
        $query = $this->db->get();
        
        return $query->num_rows() > 0 ? $query->result_array() : [];
    }
    
    public function obter_recibo($id) {
        $this->db->select('r.*, t.nome as taxa_nome, u.nome as nome_usuario, u.email');
        $this->db->from('recibos r');
        $this->db->join('taxas t', 't.id = r.taxa_id', 'left');
        $this->db->join('usuarios u', 'u.ime = r.ime', 'left');
        $this->db->where('r.id', $id);
        return $this->db->get()->row_array();
    }
    
    public function confirmar_pagamento($id) {
        $dados = [
            'status_pagamento' => 'confirmado',
            'data_confirmacao' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $id);
        return $this->db->update('recibos', $dados);
    }
    
    // Relatórios
    public function relatorio_recebimentos($data_inicio, $data_fim) {
        $this->db->select('SUM(valor_pago) as total, tipo_recibo, COUNT(*) as quantidade');
        $this->db->where('data_pagamento >=', $data_inicio);
        $this->db->where('data_pagamento <=', $data_fim);
        $this->db->where('status_pagamento', 'confirmado');
        $this->db->group_by('tipo_recibo');
        return $this->db->get('recibos')->result_array();
    }

    // Método para verificar se existem dados nas tabelas principais
    public function verificar_dados_iniciais() {
        $status = [
            'taxas' => $this->db->count_all('taxas') > 0,
            'recibos' => $this->db->count_all('recibos') > 0,
            'caixa' => $this->db->count_all('caixa') > 0
        ];
        
        return $status;
    }

    // Método para Dashboard
    public function obter_dados_dashboard() {
        $hoje = date('Y-m-d');
        $mes_atual = date('Y-m');
        
        $dados = [
            'total_recibos' => $this->db->count_all('recibos'),
            'recibos_pendentes' => $this->db->where('status_pagamento', 'pendente')->count_all_results('recibos'),
            'receita_mes' => $this->db->select_sum('valor_pago')
                                    ->where("DATE_FORMAT(data_pagamento, '%Y-%m') =", $mes_atual)
                                    ->where('status_pagamento', 'confirmado')
                                    ->get('recibos')
                                    ->row()
                                    ->valor_pago ?? 0,
            'receita_hoje' => $this->db->select_sum('valor_pago')
                                     ->where("DATE(data_pagamento)", $hoje)
                                     ->where('status_pagamento', 'confirmado')
                                     ->get('recibos')
                                     ->row()
                                     ->valor_pago ?? 0
        ];
        
        return $dados;
    }

    // Método para Relatórios
    public function gerar_relatorio($tipo, $filtros = []) {
        switch ($tipo) {
            case 'receitas':
                return $this->relatorio_receitas($filtros);
            case 'taxas':
                return $this->relatorio_taxas($filtros);
            default:
                return [];
        }
    }

    private function relatorio_receitas($filtros) {
        if (!empty($filtros['data_inicio'])) {
            $this->db->where('data_pagamento >=', $filtros['data_inicio']);
        }
        if (!empty($filtros['data_fim'])) {
            $this->db->where('data_pagamento <=', $filtros['data_fim']);
        }
        
        $this->db->select('DATE(data_pagamento) as data, SUM(valor_pago) as total')
                 ->where('status_pagamento', 'confirmado')
                 ->group_by('DATE(data_pagamento)')
                 ->order_by('data_pagamento', 'DESC');
        
        $query = $this->db->get('recibos');
        
        return $query->num_rows() > 0 ? $query->result_array() : [];
    }

    private function relatorio_taxas($filtros) {
        $this->db->select('t.nome, COUNT(r.id) as quantidade, SUM(r.valor_pago) as total')
                 ->from('taxas t')
                 ->join('recibos r', 'r.taxa_id = t.id', 'left')
                 ->where('r.status_pagamento', 'confirmado')
                 ->group_by('t.id');
        
        $query = $this->db->get();
        
        return $query->num_rows() > 0 ? $query->result_array() : [];
    }

    // Adicione este método na classe M_financeiro
    public function obter_recibos_recentes($limite = 5) {
        $this->db->select('r.*, u.nome as nome_usuario');
        $this->db->from('recibos r');
        $this->db->join('usuarios u', 'u.ime = r.ime', 'left');
        $this->db->order_by('r.data_pagamento', 'DESC');
        $this->db->limit($limite);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function buscar_membro_por_ime($ime) {
        $this->db->select('ime, nome, email');
        $this->db->where('ime', $ime);
        return $this->db->get('usuarios')->row_array();
    }

    public function validar_recibo($dados) {
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
            $membro = $this->buscar_membro_por_ime($dados['ime']);
            if (!$membro) {
                return ['status' => false, 'mensagem' => 'Membro não encontrado'];
            }

            return ['status' => true, 'mensagem' => 'Dados válidos'];

        } catch (Exception $e) {
            log_message('error', 'Exceção na validação do recibo: ' . $e->getMessage());
            return ['status' => false, 'mensagem' => 'Erro ao validar dados'];
        }
    }

    public function inserir_recibo($dados) {
        try {
            // Validação básica
            if (empty($dados['ime']) || empty($dados['valor_pago']) || 
                empty($dados['forma_pagamento']) || empty($dados['tipo_recibo'])) {
                log_message('error', 'Dados incompletos para inserir recibo');
                return false;
            }

            // Garante que todos os campos necessários estão presentes
            $dados_insert = [
                'ime' => $dados['ime'],
                'valor_pago' => $dados['valor_pago'],
                'forma_pagamento' => $dados['forma_pagamento'],
                'data_pagamento' => $dados['data_pagamento'],
                'recebido_por' => $dados['recebido_por'],
                'meio_pagamento' => $dados['meio_pagamento'],
                'numero_transacao' => $dados['numero_transacao'],
                'status_pagamento' => $dados['status_pagamento'],
                'tipo_recibo' => $dados['tipo_recibo'],
                'descricao' => $dados['descricao'],
                'taxa_id' => $dados['taxa_id']
            ];

            $this->db->insert('recibos', $dados_insert);
            
            if ($this->db->affected_rows() > 0) {
                return $this->db->insert_id();
            }

            log_message('error', 'Erro ao inserir recibo: ' . $this->db->error()['message']);
            return false;

        } catch (Exception $e) {
            log_message('error', 'Exceção ao inserir recibo: ' . $e->getMessage());
            return false;
        }
    }

    public function inserir_caixa($dados) {
        try {
            // Log para debug
            log_message('debug', 'Tentando inserir registro no caixa: ' . json_encode($dados));

            // Validação dos campos obrigatórios
            $campos_obrigatorios = ['descricao', 'tipo', 'valor', 'categoria', 'recibo_id', 'ime_responsavel'];
            foreach ($campos_obrigatorios as $campo) {
                if (empty($dados[$campo])) {
                    log_message('error', 'Campo obrigatório ausente no caixa: ' . $campo);
                    return false;
                }
            }

            // Validação do valor
            if (!is_numeric($dados['valor']) || $dados['valor'] <= 0) {
                log_message('error', 'Valor inválido para o caixa: ' . $dados['valor']);
                return false;
            }

            // Garante que a data de registro está presente
            if (empty($dados['data_registro'])) {
                $dados['data_registro'] = date('Y-m-d H:i:s');
            }

            // Insere no caixa
            $this->db->insert('caixa', $dados);
            
            if ($this->db->affected_rows() > 0) {
                log_message('info', 'Registro inserido no caixa com sucesso');
                return true;
            }

            log_message('error', 'Erro ao inserir no caixa: ' . $this->db->error()['message']);
            return false;

        } catch (Exception $e) {
            log_message('error', 'Exceção ao inserir no caixa: ' . $e->getMessage());
            return false;
        }
    }

    public function obter_ultimo_numero_transacao($forma_pagamento) {
        try {
            $this->db->select('numero_transacao');
            $this->db->where('forma_pagamento', $forma_pagamento);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            
            $query = $this->db->get('recibos');
            
            if ($query->num_rows() > 0) {
                return $query->row()->numero_transacao;
            }
            
            return null;
        } catch (Exception $e) {
            log_message('error', 'Erro ao obter último número de transação: ' . $e->getMessage());
            return null;
        }
    }
}
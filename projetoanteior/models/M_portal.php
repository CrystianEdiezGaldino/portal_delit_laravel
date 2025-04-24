<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_portal extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    // Funções para Tutoriais
    public function listar_tutoriais() {
        return $this->db->get('tutoriais')->result_array();
    }

    // Funções para Carteira
    public function obter_dados_carteira($ime) {
        $this->db->where('ime_num', $ime);
        return $this->db->get('carteira')->row_array();
    }

    // Funções para Calendário
    public function listar_eventos() {
        return $this->db->get('eventos')->result_array();
    }

    // Funções para Boletins
    public function listar_boletins() {
        return $this->db->get('boletins')->result_array();
    }

    // Funções para Publicações
    public function listar_publicacoes() {
        return $this->db->get('publicacoes')->result_array();
    }

    // Funções para Perfil do Membro
    public function obter_perfil_membro($ime) {
        $this->db->where('ime_num', $ime);
        return $this->db->get('pk_usuarios')->row_array();
    }

    // Funções para Histórico de Participação
    public function obter_historico_participacao($ime) {
        $this->db->where('ime_num', $ime);
        return $this->db->get('historico_participacao')->result_array();
    }

    // Funções para Delegacias
    public function listar_delegacias() {
        return $this->db->get('delegacias')->result_array();
    }

    // Funções para Clube Montezuma
    public function obter_dados_clube($ime) {
        $this->db->where('ime_num', $ime);
        return $this->db->get('clube_montezuma')->row_array();
    }

    // Funções para IEAD
    public function listar_conteudos_iead() {
        return $this->db->get('iead_conteudos')->result_array();
    }

    // Funções para Anuidades
    public function obter_anuidades($ime) {
        $this->db->where('ime_num', $ime);
        return $this->db->get('anuidades')->result_array();
    }

    // Funções para Elevações
    public function obter_elevacoes($ime) {
        $this->db->where('ime_num', $ime);
        return $this->db->get('elevacoes')->result_array();
    }

    // Funções para Diploma Digital
    public function obter_diploma($ime) {
        $this->db->where('ime_num', $ime);
        return $this->db->get('diplomas')->row_array();
    }

    // Função para enviar mensagem de contato
    public function enviar_mensagem_contato($dados) {
        return $this->db->insert('mensagens_contato', $dados);
    }
} 
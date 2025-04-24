<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evento_model extends CI_Model {
    
    private $tabela = 'eventos';

    public function getAll() {
        $query = $this->db->get('eventos');
        return $query->num_rows() > 0 ? $query->result() : [];
    }

    public function inserir($dados) {
        return $this->db->insert($this->tabela, $dados);
    }

    public function atualizar($dados) {
        return $this->db->where('id', $dados['id'])
                        ->update($this->tabela, $dados);
    }

    public function excluir($id) {
        return $this->db->where('id', $id)
                        ->delete($this->tabela);
    }
} 
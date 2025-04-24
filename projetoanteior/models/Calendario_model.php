<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario_model extends CI_Model {

    public function get_all_events() {
        $query = $this->db->get('eventos');
        return $query->result_array();
    }

    public function save_event($dados) {
        if (isset($dados['id']) && !empty($dados['id'])) {
            $this->db->where('id', $dados['id']);
            $this->db->update('eventos', $dados);
        } else {
            $this->db->insert('eventos', $dados);
        }
    }

    public function delete_event($id) {
        $this->db->where('id', $id);
        $this->db->delete('eventos');
    }

    public function update_event($dados) {
        $this->db->where('id', $dados['id']);
        $this->db->update('eventos', $dados);
    }
}
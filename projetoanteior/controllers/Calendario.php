<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Calendario_model');
    }

    public function getEventos() {
        $eventos = $this->Calendario_model->get_all_events();
        echo json_encode($eventos);
    }

    public function salvarEvento() {
        $dados = $this->input->post();
        $this->Calendario_model->save_event($dados);
    }

    public function excluirEvento() {
        $id = $this->input->post('id');
        $this->Calendario_model->delete_event($id);
    }

    public function atualizarEvento() {
        $dados = $this->input->post();
        $this->Calendario_model->update_event($dados);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'../vendor/tecnickcom/tcpdf/tcpdf.php';

/**
 * Classe personalizada do TCPDF para customização de cabeçalho e rodapé
 */
class MYPDF extends TCPDF {
    public function Header() {}
    public function Footer() {}
}

/**
 * Controlador responsável pelo gerenciamento financeiro do sistema
 * Controla taxas, recibos e relatórios financeiros
 */
class Financeiro extends CI_Controller {
    
    /**
     * Construtor da classe
     * Carrega modelos e bibliotecas necessárias
     * Verifica autenticação e permissões do usuário
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('M_financeiro');
        $this->load->model('M_email');
        $this->load->model('M_cadastro');
        $this->load->helper(['url', 'form']);
        
        // Verifica se está logado
        if (!$this->session->userdata('logged_in')) {
            redirect('controlador/login');
        }
        
        // Verifica se tem permissão (admin ou atendente)
        $role = $this->session->userdata('user_data')['role'];
        if (!in_array($role, ['admin', 'atendente'])) {
            show_404();
        }
    }
    
    /**
     * Verifica se o usuário está autenticado
     * Redireciona para login se não estiver
     */
    private function check_login() {
        if (!$this->session->userdata('logged_in')) {
            redirect('controlador/login');
        }
    }

    /**
     * Carrega o template padrão com header, sidebar, conteúdo e footer
     * @param string $page Nome da view a ser carregada
     * @param array $view_data Dados adicionais para a view
     */
    private function load_page($page, $view_data = []) {
        $data = [
            'current_page' => $page,
            'user_data' => $this->session->userdata('user_data')
        ];
        
        if (!empty($view_data)) {
            $data = array_merge($data, $view_data);
        }

        $this->load->view('header', $data);
        $this->load->view('sidebar', $data);
        $this->load->view($page, $data);
        $this->load->view('footer');
    }
    
    /**
     * Página inicial do módulo financeiro
     * Exibe dashboard com resumo financeiro e recibos recentes
     */
    public function index() {
        $status_dados = $this->M_financeiro->verificar_dados_iniciais();
        
        if (!array_filter($status_dados)) {
            $this->session->set_flashdata('info', 'O módulo financeiro ainda não possui dados cadastrados.');
        }
        
        $data['dashboard'] = $this->M_financeiro->obter_dados_dashboard();
        $data['status_dados'] = $status_dados;
        $data['recibos_recentes'] = $this->M_financeiro->obter_recibos_recentes();
        
        $this->load_page('financeiro/dashboard', $data);
    }
    
    /**
     * Exibe a página de gerenciamento de taxas
     * Lista todas as taxas cadastradas no sistema
     */
    public function taxas() {
        // Verifica se está logado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['titulo'] = 'Gerenciamento de Taxas';
        $data['taxas'] = $this->M_financeiro->listar_taxas();
        
        // Carrega as views
        $this->load->view('header', $data);
        $this->load->view('sidebar');
        $this->load->view('financeiro/taxas', $data);
        $this->load->view('footer');
    }
    
    /**
     * Exibe formulário para cadastro de nova taxa
     */
    public function nova_taxa() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['titulo'] = 'Nova Taxa';
        
        $this->load->view('header', $data);
        $this->load->view('sidebar');
        $this->load->view('financeiro/form_taxa', $data);
        $this->load->view('footer');
    }
    
    /**
     * Processa o salvamento de uma taxa (nova ou edição)
     * Valida e salva os dados no banco
     */
    public function salvar_taxa() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $dados = array(
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'valor' => str_replace(',', '.', str_replace('.', '', $this->input->post('valor'))),
            'tipo' => $this->input->post('tipo'),
            'status' => $this->input->post('status')
        );

        if ($this->input->post('id')) {
            $dados['id'] = $this->input->post('id');
        }

        if ($this->M_financeiro->salvar_taxa($dados)) {
            $this->session->set_flashdata('success', 'Taxa salva com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao salvar taxa!');
        }

        redirect('financeiro/taxas');
    }
    
    /**
     * Processa a geração de um novo recibo
     * Valida dados, gera recibo e envia por email se configurado
     */
    public function gerar_recibo() {
        try {
            // Validações básicas
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('ime', 'IME', 'required');
            $this->form_validation->set_rules('valor', 'Valor', 'required');
            $this->form_validation->set_rules('forma_pagamento', 'Forma de Pagamento', 'required');
            $this->form_validation->set_rules('tipo_recibo', 'Tipo de Recibo', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors());
            }

            // Processa o valor
            $valor = str_replace(['.', ','], ['', '.'], $this->input->post('valor'));
            
            if (!is_numeric($valor) || $valor <= 0) {
                throw new Exception('Valor inválido');
            }

            // Prepara os dados
            $dados = [
                'ime' => $this->input->post('ime'),
                'valor_pago' => $valor,
                'forma_pagamento' => $this->input->post('forma_pagamento'),
                'meio_pagamento' => $this->input->post('forma_pagamento'),
                'tipo_recibo' => $this->input->post('tipo_recibo'),
                'descricao' => $this->input->post('descricao'),
                'taxa_id' => $this->input->post('taxa_id') ?: null,
                'recebido_por' => $this->session->userdata('user_data')['nome'],
                'numero_transacao' => $this->input->post('numero_transacao'),
                'status_pagamento' => 'confirmado',
                'data_pagamento' => date('Y-m-d H:i:s'),
                'data_confirmacao' => date('Y-m-d H:i:s')
            ];

            // Inicia transação
            $this->db->trans_start();
            
            $recibo_id = $this->M_financeiro->gerar_recibo($dados);
            
            if (!$recibo_id) {
                throw new Exception('Erro ao gerar recibo');
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Erro na transação do banco de dados');
            }

            $this->session->set_flashdata('success', 'Recibo #' . $recibo_id . ' gerado com sucesso!');
            redirect('financeiro');

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Erro ao gerar recibo: ' . $e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('financeiro/gerar');
        }
    }
    
    /**
     * Exibe os detalhes de um recibo específico
     * @param int $id ID do recibo
     */
    public function visualizar_recibo($id) {
        $data['recibo'] = $this->M_financeiro->obter_recibo($id);
        
        if (!$data['recibo']) {
            $this->session->set_flashdata('error', 'Recibo não encontrado.');
            redirect('financeiro/recibos');
        }
        
        $this->load_page('financeiro/recibos/visualizar', $data);
    }
    
    /**
     * Gera PDF do recibo para download
     * @param int $id ID do recibo
     */
    public function gerar_pdf_recibo($id) {
        $recibo = $this->M_financeiro->obter_recibo($id);
        
        if (!$recibo) {
            $this->session->set_flashdata('error', 'Recibo não encontrado.');
            redirect('financeiro/recibos');
        }

        // Configuração do TCPDF
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Configurações básicas
        $pdf->SetCreator('Sistema Financeiro');
        $pdf->SetAuthor('Delit Curitiba');
        $pdf->SetTitle('Recibo #' . $id);
        
        // Configurações de margem
        $pdf->SetMargins(15, 15, 15);
        
        // Adiciona uma página
        $pdf->AddPage();

        // Caminho para a logo
        $logo_path = FCPATH . 'assets/images/logo_delit_curitiba.png';
        
        // Gera o HTML do recibo
        $html = '
            <style>
                table { 
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 5px;
                }
                td {
                    padding: 2px;
                    vertical-align: middle;
                    font-size: 9pt;
                }
                .header {
                    width: 100%;
                    margin-bottom: 10px;
                }
                .header td {
                    text-align: center;
                    font-size: 11pt;
                    font-weight: bold;
                }
                .logo-cell {
                    width: 20%;
                    text-align: center;
                }
                .title-cell {
                    width: 80%;
                    text-align: left;
                    padding-left: 10px;
                }
            </style>
            
            <table class="header" border="0">
                <tr>
                    <td class="logo-cell">
                        <img src="'.$logo_path.'" width="80">
                    </td>
                    <td class="title-cell">
                        SUPREMO CONSELHO DO BRASIL DO GRAU 33<br>
                        PARA O R.:E.:A.:A.:<br>
                        Delegacia Litúrgica Sul-Paraná
                    </td>
                </tr>
            </table>
        
            <h2 style="text-align: center;">RECIBO #' . $recibo['id'] . '</h2>
            
            <table border="1" cellpadding="2">
                <tr>
                    <td width="30%"><strong>Data:</strong></td>
                    <td width="70%">' . date('d/m/Y H:i', strtotime($recibo['data_pagamento'])) . '</td>
                </tr>
                <tr>
                    <td><strong>IME:</strong></td>
                    <td>' . $recibo['ime'] . '</td>
                </tr>
                <tr>
                    <td><strong>Nome:</strong></td>
                    <td>' . ($recibo['nome_usuario'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td><strong>Valor:</strong></td>
                    <td>R$ ' . number_format($recibo['valor_pago'], 2, ',', '.') . '</td>
                </tr>
                <tr>
                    <td><strong>Taxa:</strong></td>
                    <td>' . ($recibo['taxa_nome'] ?? 'N/A') . '</td>
                </tr>
                <tr>
                    <td><strong>Forma de Pagamento:</strong></td>
                    <td>' . ucfirst($recibo['forma_pagamento']) . '</td>
                </tr>
                <tr>
                    <td><strong>Recebido por:</strong></td>
                    <td>' . $recibo['recebido_por'] . '</td>
                </tr>
            </table>';
        
            if ($recibo['descricao']) {
                $html .= '
                <table border="1" cellpadding="2" style="margin-top: 10px;">
                    <tr>
                        <td><strong>Descrição:</strong></td>
                    </tr>
                    <tr>
                        <td>' . nl2br($recibo['descricao']) . '</td>
                    </tr>
                </table>';
            }
        
            $html .= '
            <div style="margin-top:20px; text-align:center; font-size: 8pt;">
                R: Mal. Deodoro, 502 - 7º andar - Sala 710-Centro-Curitiba-PR-80010-010 - Fone (41) 3222-5178<br>
                e-mail: delitsulpr@gmail.com
            </div>';

        // Gera o PDF
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Gera o arquivo
        $pdf->Output('recibo_'.$id.'.pdf', 'D');
    }
    
    /**
     * Envia recibo por email para o usuário
     * @param int $recibo_id ID do recibo
     */
    private function enviar_recibo_email($recibo_id) {
        $recibo = $this->M_financeiro->obter_recibo($recibo_id);
        $usuario = $this->M_cadastro->buscar_usuario_por_ime($recibo['ime']);
        
        $assunto = 'Recibo de Pagamento #'.$recibo_id;
        $corpo = $this->load->view('financeiro/recibos/template_email', 
            ['recibo' => $recibo, 'usuario' => $usuario], 
            true
        );
        
        $this->M_email->enviar_email($usuario['email'], $assunto, $corpo);
    }
    
    /**
     * Exibe página de relatórios financeiros
     * Permite filtrar por período e gerar relatórios
     */
    public function relatorios() {
        if ($this->input->post()) {
            $data_inicio = $this->input->post('data_inicio');
            $data_fim = $this->input->post('data_fim');
            $data['relatorio'] = $this->M_financeiro->relatorio_recebimentos($data_inicio, $data_fim);
        }
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('financeiro/relatorios/index', $data ?? []);
        $this->load->view('footer');
    }

    /**
     * Lista todos os recibos com filtros
     * Permite filtrar por status e período
     */
    public function recibos() {
        $filtros = [
            'status' => $this->input->get('status'),
            'data_inicio' => $this->input->get('data_inicio'),
            'data_fim' => $this->input->get('data_fim')
        ];
        
        $data['recibos'] = $this->M_financeiro->listar_recibos($filtros);
        
        if (empty($data['recibos'])) {
            $this->session->set_flashdata('info', 'Nenhum recibo encontrado.');
        }
        
        $this->load_page('financeiro/recibos/index', $data);
    }

    /**
     * Exibe formulário para gerar novo recibo
     * Carrega taxas ativas para seleção
     */
    public function gerar() {
        // Verifica permissões
        if (!in_array($this->session->userdata('user_data')['role'], ['admin', 'atendente'])) {
            $this->session->set_flashdata('error', 'Acesso não autorizado');
            redirect('financeiro');
        }

        // Carrega dados para o formulário e converte para array
        $taxas = $this->M_financeiro->listar_taxas('ativa');
        $data['taxas'] = array_map(function($taxa) {
            return (array) $taxa;
        }, $taxas);
        
        // Carrega a view usando load_page
        $this->load_page('financeiro/gerar_recibo', $data);
    }

    /**
     * Exibe formulário completo para novo recibo
     * Inclui todas as opções de pagamento e tipos de recibo
     */
    public function novo_recibo() {
        // Verifica permissões
        if (!in_array($this->session->userdata('user_data')['role'], ['admin', 'atendente'])) {
            $this->session->set_flashdata('error', 'Acesso não autorizado');
            redirect('financeiro');
        }

        // Carrega dados para o formulário
        $data = [
            'taxas' => $this->M_financeiro->listar_taxas('ativa'),
            'formas_pagamento' => [
                'dinheiro' => 'Dinheiro',
                'cartão de crédito' => 'Cartão de Crédito',
                'cartão de débito' => 'Cartão de Débito',
                'transferência' => 'Transferência',
                'pix' => 'PIX',
                'boleto' => 'Boleto'
            ],
            'tipos_recibo' => [
                'mensalidade' => 'Mensalidade',
                'doação' => 'Doação',
                'outro' => 'Outro'
            ]
        ];
        
        // Carrega a view
        $this->load_page('financeiro/recibos/novo', $data);
    }


    private function gerar_numero_transacao($forma_pagamento, $ime) {

        $data = date('YmdHis');
        $random = strtoupper(substr(uniqid(), -4));
        $prefixo = '';
        
        switch(strtolower($forma_pagamento)) {
            case 'pix':
                $prefixo = 'PIX';
                break;
            case 'cartão de crédito':
                $prefixo = 'CRD';
                break;
            case 'cartão de débito':
                $prefixo = 'DEB';
                break;
            case 'transferência':
                $prefixo = 'TRF';
                break;
            case 'boleto':
                $prefixo = 'BOL';
                break;
            default:
                $prefixo = 'PAG';
        }
        
        return $prefixo . $data . $random . str_replace('.', '', $ime);
    }

    public function salvar_recibo() {
        try {
            // Format valor_pago from Brazilian format to database format
            $valor_pago = str_replace(['.', ','], ['', '.'], $this->input->post('valor_pago'));
            
            // Validate required fields
            $required_fields = [
                'ime' => $this->input->post('ime'),
                'valor_pago' => $valor_pago,
                'forma_pagamento' => $this->input->post('forma_pagamento'),
                'tipo_recibo' => $this->input->post('tipo_recibo')
            ];

            foreach ($required_fields as $field => $value) {
                if (empty($value)) {
                    throw new Exception("O campo " . ucfirst(str_replace('_', ' ', $field)) . " é obrigatório");
                }
            }

            // Validate IME exists
            $usuario = $this->M_cadastro->buscar_usuario_por_ime($this->input->post('ime'));
            if (!$usuario) {
                throw new Exception("IME não encontrado");
            }

            // Validate valor is numeric and greater than 0
            if (!is_numeric($valor_pago) || $valor_pago <= 0) {
                throw new Exception("Valor inválido");
            }

            // Start database transaction
            $this->db->trans_begin();

            // Generate transaction number if empty
            $numero_transacao = $this->input->post('numero_transacao');
            if (empty($numero_transacao)) {
                $numero_transacao = $this->gerar_numero_transacao(
                    $this->input->post('forma_pagamento'),
                    $this->input->post('ime')
                );
            }

            // Debug data
//             echo "IME: " . $this->input->post('ime') . "<br>";
//             echo "Valor Pago: " . $valor_pago . "<br>";
//             echo "Forma de Pagamento: " . $this->input->post('forma_pagamento') . "<br>";
//             echo "Tipo de Recibo: " . $this->input->post('tipo_recibo') . "<br>";
//             echo "Descrição: " . $this->input->post('descricao') . "<br>";
//             echo "Número da Transação: " . $numero_transacao . "<br>";
//             echo "Taxa ID: " . ($this->input->post('taxa_id') ?: 'null') . "<br>";
// $nome_recebido = $this->db->select('nome')
//                           ->from('usuarios')
//                           ->where('ime', $this->input->post('ime'))
//                           ->get()
//                           ->row()
//                           ->nome;
// echo "'recebido_por' => " . $nome_recebido . ",";
//             echo "Data do Pagamento: " . date('Y-m-d H:i:s') . "<br>";
//             echo "Status do Pagamento: confirmado<br>";
          
//             exit;


            // Prepare recibo data
            $dados_recibo = [
                'ime' => $this->input->post('ime'),
                'valor_pago' => $valor_pago,
                'forma_pagamento' => $this->input->post('forma_pagamento'),
                'meio_pagamento' => $this->input->post('meio_pagamento'), // Added this field
                'tipo_recibo' => $this->input->post('tipo_recibo'),
                'descricao' => $this->input->post('descricao'),
                'numero_transacao' => $numero_transacao,
                'taxa_id' => $this->input->post('taxa_id') ?: null,
                'recebido_por' => $this->db->select('nome')
                                        ->from('usuarios')
                                        ->where('ime', $this->input->post('ime'))
                                        ->get()
                                        ->row()
                                        ->nome,
                'data_pagamento' => date('Y-m-d H:i:s'),
                'status_pagamento' => 'confirmado'
            ];

  
      
            // Insert recibo
            $this->db->insert('recibos', $dados_recibo);
            $recibo_id = $this->db->insert_id();

            if (!$recibo_id) {
                throw new Exception("Erro ao gerar recibo");
            }

            // Register in caixa
// echo "Descrição: " . ($dados_recibo['descricao'] ?: 'Recibo #' . $recibo_id) . "<br>";
// echo "Tipo: entrada<br>";
// echo "Valor: " . $valor_pago . "<br>";
// echo "Categoria: " . $dados_recibo['tipo_recibo'] . "<br>";
// echo "Recibo ID: " . $recibo_id . "<br>";
// echo "IME Responsável: " . $this->input->post('ime') . "<br>";
// echo "Data Movimentação: " . date('Y-m-d H:i:s') . "<br>";

$dados_caixa = [
    'descricao' => $dados_recibo['descricao'] ?: 'Recibo #' . $recibo_id,
    'tipo' => 'entrada',
    'valor' => $valor_pago,
    'categoria' => $dados_recibo['tipo_recibo'],
    'recibo_id' => $recibo_id,
    'ime_responsavel' => $this->input->post('ime'),
    'data_movimentacao' => date('Y-m-d H:i:s')
];

            $this->db->insert('caixa', $dados_caixa);

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Erro na transação do banco de dados");
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Recibo #' . $recibo_id . ' gerado com sucesso!');
            redirect('financeiro/visualizar_recibo/' . $recibo_id);

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Erro ao gerar recibo: ' . $e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('financeiro/gerar');
        }
    }

    public function buscar_membro() {
        $ime = $this->input->post('ime');
        
        $membro = $this->db->select('nome, ime')
                       ->from('usuarios')
                       ->where('ime', $ime)
                       ->get()
                       ->row_array();
        
        if ($membro) {
            echo json_encode(['success' => true, 'membro' => $membro]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
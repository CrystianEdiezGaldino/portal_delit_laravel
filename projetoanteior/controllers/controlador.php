<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'../vendor/tecnickcom/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {}
  public function Footer() {}
}

class controlador extends CI_Controller {
  
  public function __construct() {
    parent::__construct();
    
    // Carrega helpers essenciais
    $this->load->helper(['form', 'url', 'security', 'text']);
    
    // Carrega bibliotecas essenciais
    $this->load->library(['session', 'form_validation']);
    
    // Carrega modelos
    $this->load->model('M_cadastro');
    $this->load->model('M_email');
}

/**
 * Verifica se o usuário está logado
 * Redireciona para a página de login se não estiver autenticado
 */
private function check_login() {
    if (!$this->session->userdata('logged_in')) {
        redirect('controlador/login');
    }
}

/**
 * Carrega uma página com o template padrão (header, sidebar, conteúdo e footer)
 * @param string $page Nome da view a ser carregada
 * @param array $view_data Dados adicionais para passar para a view
 */
private function load_page($page, $view_data = []) {
    // Verifica login para todas as páginas exceto login
    if ($page !== 'login') {
      $this->check_login();
    }

    $data = [
      'current_page' => $page,
      'user_data' => $this->session->userdata('user_data')
    ];
    
    if (!empty($view_data)) {
      $data = array_merge($data, $view_data);
    }

    $this->load->view('header', $data);
    if ($page !== 'login') {
      $this->load->view('sidebar', $data);
    }
    $this->load->view($page, $data);
    $this->load->view('footer');
}
  
/**
 * Página inicial do sistema
 * Redireciona para o dashboard se autenticado
 */
public function index() {
 
    $this->check_login();
    $this->load_page('dashboard');
  }

/**
 * Gerencia o processo de login do usuário
 * Valida credenciais e configura a sessão
 */
public function login() {

    if ($this->input->post()) {
      // Sanitiza e valida entrada
      $ime = trim((string) $this->input->post('ime', true)); 
      $senha = trim((string) $this->input->post('senha', true));
    // Verifica se os campos foram preenchidos
    if (empty($ime) || empty($senha)) {
      $this->session->set_flashdata('error', 'Preencha todos os campos.');
      redirect('controlador/login');
      return;
    }
      $user = $this->M_cadastro->validate_login($ime, $senha);
  

      if ($user) {
        $userData = $this->M_cadastro-> buscar_usuario_por_ime($ime);
        $roleData = $this->M_cadastro->buscar_todos_os_dados_tb_usuario($ime);
        // Adicionar o role ao userData
        $userData['role'] = isset($roleData['role']) ? $roleData['role'] : null;
        
        $this->session->set_userdata([
          'ime' => $ime,
          'user_data' => $userData,
          'logged_in' => true
        ]);
     
        // var_dump(  $userData); exit;
        redirect('controlador/dashboard');
      } else {
        $this->session->set_flashdata('error', 'Login inválido');
        redirect('controlador/login');
      }
    }

    $this->load_page('login');
  }

/**
 * Carrega a página do dashboard
 * Requer autenticação
 */
public function dashboard() {
    $this->check_login();
    $this->load_page('dashboard');
  }

/**
 * Realiza o logout do usuário
 * Destrói a sessão e redireciona para login
 */
public function logout() {
    $this->session->sess_destroy();
    redirect('controlador/login');
  }

  // Páginas do Menu Principal
  public function tutoriais() {
    $this->check_login();
    $this->load_page('tutoriais');
  }

  public function carteira() {
    $this->check_login();
    $this->load_page('carteira');
  }

  public function calendario() {
    $this->check_login();
    $this->load_page('calendario');
  }

  public function boletins() {
    $this->check_login();
    $this->load_page('boletins');
  }

  public function publicacoes() {
    $this->check_login();
    $this->load_page('publicacoes');
  }

  // Submenu Membros
  public function perfil_membro() {
    $this->check_login();
    $this->load_page('perfil_membro');
  }

  public function historico_participacao() {
    $this->check_login();
    $this->load_page('historico_participacao');
  }

  // Outras Páginas
  public function delegacias() {
    $this->check_login();
    $this->load_page('delegacias');
  }

  public function contato() {
    $this->check_login();
    $this->load_page('contato');
  }

  // Menu Especial
  public function clube() {
    $this->check_login();
    $this->load_page('clube');
  }

  public function iead() {
    $this->check_login();
    $this->load_page('iead');
  }

  public function anuidades() {
    $this->check_login();
    $this->load_page('anuidades');
  }

  public function elevacoes() {
    $this->check_login();
    $this->load_page('elevacoes');
  }

  public function diploma() {
    $this->check_login();
    $this->load_page('diploma');
  }
  public function enviar_mensagem() {
    $this->check_login();
    
    // Get form data
    $nome = $this->input->post('nome');
    $email = $this->input->post('email');
    $assunto = $this->input->post('assunto');
    $mensagem = $this->input->post('mensagem');
    
    // Prepare email content
    $corpo = "
        <h2>Nova mensagem de contato</h2>
        <p><strong>Nome:</strong> {$nome}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Assunto:</strong> {$assunto}</p>
        <hr>
        <h3>Mensagem:</h3>
        <p>{$mensagem}</p>
    ";
    
    // Send email
    $enviado = $this->M_email->enviar_email(
        'no-reply@delitcuritiba.org',
        'Contato via Portal: ' . $assunto,
        $corpo
    );
    if ($enviado) {
        $this->session->set_flashdata('success', 'Mensagem enviada com sucesso!');
    } else {
        $this->session->set_flashdata('error', 'Erro ao enviar mensagem. Tente novamente.');
    }
    
    // Add JavaScript to clear flash data after 5 seconds
    $script = "
        <script>
        setTimeout(function() {
            fetch('".base_url('controlador/clearFlashData')."', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
        }, 5000);
        </script>
    ";
    
    $this->session->set_flashdata('script', $script);
    redirect('contato');
}
public function clear_flash_data() {
    // Clear specific flash data
    $this->session->unset_userdata('error');
    $this->session->unset_userdata('success');
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}

/**
 * Gerencia os chamados do sistema
 * Lista todos os chamados com filtros e ordenação
 * Admins e atendentes veem todos os chamados, outros usuários veem apenas os seus
 */
public function chamado_index() {
  $this->check_login();
  
  $user_role = $this->session->userdata('user_data')['role'];
  $user_ime = $this->session->userdata('ime');
  
  // Filtros
  $filtros = [
      'status' => $this->input->get('status'),
      'prioridade' => $this->input->get('prioridade'),
      'search' => $this->input->get('search')
  ];
  
  // Se não for admin ou atendente, mostra apenas os chamados do usuário
  if (!in_array($user_role, ['admin', 'atendente'])) {
      $filtros['usuario_ime'] = $user_ime;
  }
  
  // Ordenação - chamados abertos primeiro, depois por data decrescente
  $ordenacao = [
      'campo' => 'status',
      'direcao' => 'ASC', // 'aberto' vem primeiro
      'segundo_campo' => 'data_abertura',
      'segunda_direcao' => 'DESC' // mais recentes primeiro
  ];
  
  $data['chamados'] = $this->M_cadastro->chamado_listar_com_filtros($filtros, $ordenacao);
  $data['user_role'] = $user_role;
  
  $this->load_page('chamado/index', $data);
}


/**
 * Exibe o formulário para abertura de novo chamado
 * Requer autenticação
 */
public function primeiro_acesso() {
    $this->load->library('form_validation');
    
    // Validação dos campos
    $this->form_validation->set_rules('ime', 'IME', 'required');
    $this->form_validation->set_rules('cpf', 'CPF', 'required');

    
    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', 'Por favor, preencha todos os campos corretamente.');
        redirect('controlador/login');
    }
    
    $ime = $this->input->post('ime');
    $cpf = $this->input->post('cpf');



    // Verifica se o usuário existe na tabela pk_usuarios
    $usuario = $this->M_cadastro->obter_pk_usuario_por_ime($ime);

    if (!$usuario) {
        $this->session->set_flashdata('error', 'Dados não encontrados. Verifique as informações ou entre em contato com o administrador.');
        redirect('controlador/login');
    }
    
    // Verifica se o CPF e data de iniciação coincidem
    if ($usuario['cic'] !== $cpf) {
        $this->session->set_flashdata('error', 'Dados não conferem. Verifique as informações.');
        redirect('controlador/login');
    }
    
    // Gera senha aleatória
    $senha = $this->gerar_senha_aleatoria();
  
    // Verifica se já existe na tabela usuarios
    $usuario_existente = $this->M_cadastro->obter_usuario_por_ime($ime);
    
    // Busca o email na tabela usuarios

    if ($usuario_existente && !empty($usuario_existente['email'])) {
        $this->M_cadastro->atualizar_senha($ime, $senha);
        $email = $usuario_existente['email'];
    } else {
        // Cria novo usuário
        // $dados_usuario = [
        //     'ime' => $ime,
        //     'nome' => $usuario['cadastro'], // Usando o nome do pk_usuarios
        //     'email' => $usuario['email'],
        //     'senha' => md5($senha), // Convertendo para MD5 como no seu sistema
        //     'role' => 'user',
        //     'status' => 'ativo',
        //     'created_at' => date('Y-m-d H:i:s')
        // ];
       //  $this->M_cadastro->inserir_usuario($dados_usuario);
        $this->session->set_flashdata('error', 'E-mail não cadastrado, entre em contato com administrador');
        redirect('controlador/login');
        return;
   
    }
   
    // Envia e-mail com a nova senha
    $assunto = 'Acesso ao Sistema Delit Curitiba';

    $email = $usuario['email'];
    $mensagem = "
        <h2>Olá, {$usuario['cadastro']}!</h2>
        <p>Seu acesso ao sistema Delit Curitiba foi criado/atualizado com sucesso.</p>
        <p><strong>Seus dados de acesso:</strong></p>
        <ul>
            <li><strong>IME:</strong> {$ime}</li>
            <li><strong>Senha :</strong> {$senha}</li>
        </ul>
        <p>Acesse o sistema: <a href='" . base_url() . "'>" . base_url() . "</a></p>
    ";

    $enviado = $this->M_email->enviar_email($email, $assunto, $mensagem);
 
    if ($enviado) {
        $this->session->set_flashdata('success', 'Acesso criado com sucesso! Verifique seu e-mail para obter a senha.');
 
    } else {
        $this->session->set_flashdata('error', 'Senha criada, mas houve um problema ao enviar o e-mail. Entre em contato com o administrador.');
    }
    
    redirect('controlador/login');
}

private function gerar_senha_aleatoria() {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $senha = '';
    
    for ($i = 0; $i < 6; $i++) {
        $senha .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    
    return $senha;
}
public function chamado_novo() {
  $this->check_login();
  
  // Carrega dados necessários para o formulário, se houver
  $data = array();
  
  $this->load_page('chamado/novo', $data);
}

/**
 * Processa a abertura de um novo chamado
 * Valida os dados e salva no banco
 */
public function chamado_abrir() {
  $this->check_login();
  
  $this->form_validation->set_rules('titulo', 'Título', 'required');
  $this->form_validation->set_rules('descricao', 'Descrição', 'required');
  $this->form_validation->set_rules('prioridade', 'Prioridade', 'required');
  
  if ($this->form_validation->run() === FALSE) {
      $this->chamado_novo();
  } else {
      $dados = [
          'usuario_ime' => $this->session->userdata('ime'),
          'titulo' => $this->input->post('titulo'),
          'descricao' => $this->input->post('descricao'),
          'prioridade' => $this->input->post('prioridade'),
          'status' => 'aberto',
          'data_abertura' => date('Y-m-d H:i:s')
      ];
      
      $id_chamado = $this->M_cadastro->chamado_abrir($dados);
      
      $this->session->set_flashdata('success', 'Chamado aberto com sucesso!');
      redirect('chamado');
  }
}


/**
 * Processa o atendimento de um chamado
 * Apenas admins e atendentes podem atender chamados
 * @param int $id ID do chamado
 */
public function chamado_atender($id) {
  try {
      $this->check_login();
      
      // Verifica se o usuário tem permissão (admin ou atendente)
      $user_data = $this->session->userdata('user_data');
      $user_role = $user_data['role'] ?? '';
      
      if (!in_array($user_role, ['admin', 'atendente'])) {
          throw new Exception('Você não tem permissão para atender chamados');
      }
      
      $user_ime = $this->session->userdata('ime');
      $chamado = $this->M_cadastro->chamado_obter_por_id($id);
      
      // Validações do chamado
      if (!$chamado) {
          throw new Exception('Chamado não encontrado');
      }
      
      if ($chamado['status'] !== 'aberto') {
          throw new Exception('Este chamado já está '.$chamado['status']);
      }
      
      // Prepara dados para atualização
      $dados = [
          'atendente_ime' => $user_ime,
          'status' => 'em andamento',
          'data_atendimento' => date('Y-m-d H:i:s')
      ];
      
      // Atualiza o chamado
      if (!$this->M_cadastro->chamado_atualizar($id, $dados)) {
          throw new Exception('Falha ao atualizar o chamado');
      }
      
      $this->session->set_flashdata('success', 'Chamado em atendimento!');
      
  } catch (Exception $e) {
      log_message('error', 'Erro ao atender chamado: ' . $e->getMessage());
      $this->session->set_flashdata('error', $e->getMessage());
  }
  
  redirect('chamado/visualizar/'.$id);
}

/**
 * Exibe formulário para edição de chamado
 * Verifica permissões do usuário
 * @param int $id ID do chamado
 */
public function chamado_editar($id) {
  $this->check_login();
  
  // Verifica se é uma requisição POST
  if ($this->input->post()) {
      $dados = [
          'titulo' => $this->input->post('titulo'),
          'descricao' => $this->input->post('descricao'),
          'prioridade' => $this->input->post('prioridade'),
          'status' => $this->input->post('status')
      ];

      if ($this->M_cadastro->chamado_atualizar($id, $dados)) {
          $this->session->set_flashdata('success', 'Chamado atualizado com sucesso!');
          redirect('chamado/visualizar/'.$id);
      } else {
          $this->session->set_flashdata('error', 'Erro ao atualizar o chamado.');
      }
  }

  // Carrega os dados do chamado
  $data['chamado'] = $this->M_cadastro->chamado_obter_por_id($id);
  
  // Verificar se o chamado pertence ao usuário ou se é atendente
  if ($data['chamado']['usuario_ime'] != $this->session->userdata('ime') && 
      $data['chamado']['atendente_ime'] != $this->session->userdata('ime')) {
      $this->session->set_flashdata('error', 'Você não tem permissão para editar este chamado');
      redirect('chamado');
  }
  
  $this->load_page('chamado/editar', $data);
}

/**
 * Processa a conclusão de um chamado
 * Apenas o atendente responsável ou admin pode concluir
 * @param int $id ID do chamado
 */
public function chamado_concluir($id) {
  try {
      $this->check_login();
      
      // Verifica se o usuário tem permissão (admin ou atendente)
      $user_data = $this->session->userdata('user_data');
      $user_role = $user_data['role'] ?? '';
      
      if (!in_array($user_role, ['admin', 'atendente'])) {
          throw new Exception('Você não tem permissão para concluir chamados');
      }
      
      // Verifica se o chamado existe
      $chamado = $this->M_cadastro->chamado_obter_por_id($id);
   
      if (!$chamado) {
          throw new Exception('Chamado não encontrado');
      }
      
      // Verifica se o chamado está em andamento
      if ($chamado['status'] !== 'em andamento') {
          throw new Exception('Este chamado precisa estar em andamento para ser concluído');
      }
      
      // Verifica se o usuário é o atendente do chamado ou admin
      if ($chamado['atendente_ime'] == $this->session->userdata('ime') || $user_role == 'admin') {
          throw new Exception('Apenas o atendente responsável pode concluir este chamado');
      }
      
      // Atualiza o status para resolvido
      $dados = [
          'status' => 'resolvido',
          'data_fechamento' => date('Y-m-d H:i:s')
      ];
      
      if (!$this->M_cadastro->chamado_atualizar($id, $dados)) {
          throw new Exception('Falha ao atualizar o status do chamado');
      }
      
      $this->session->set_flashdata('success', 'Chamado fechado com sucesso!');
      
  } catch (Exception $e) {
      log_message('error', 'Erro ao fechar chamado: ' . $e->getMessage());
      $this->session->set_flashdata('error', $e->getMessage());
  }
  
  // Redireciona para a visualização do chamado
  redirect('chamado/visualizar/'.$id);
}

/**
 * Gera link para notificação baseado no tipo
 * @param array $notificacao Dados da notificação
 * @return string URL da notificação
 */
protected function get_notification_link($notificacao) {
  switch ($notificacao['tipo']) {
      case 'chamado':
          return site_url('chamado/visualizar/' . $notificacao['referencia_id']);
      default:
          return site_url('notificacoes/visualizar/' . $notificacao['id']);
  }
}

/**
 * Retorna o ícone apropriado para cada tipo de notificação
 * @param array $notificacao Dados da notificação
 * @return string Nome do ícone
 */
protected function get_notification_icon($notificacao) {
  $icons = [
      'chamado' => 'ticket',
      'novo' => 'plus-circle',
      'atendimento' => 'person-check',
      'conclusao' => 'check-circle',
      'edicao' => 'pencil',
      'atribuicao' => 'person-plus'
  ];
  return $icons[$notificacao['tipo']] ?? 'info-circle';
}

/**
 * Define a cor para cada tipo de notificação
 * @param array $notificacao Dados da notificação
 * @return string Nome da cor
 */
protected function get_notification_color($notificacao) {
  $colors = [
      'chamado' => 'primary',
      'novo' => 'info',
      'atendimento' => 'warning',
      'conclusao' => 'success',
      'edicao' => 'secondary',
      'atribuicao' => 'primary'
  ];
  return $colors[$notificacao['tipo']] ?? 'muted';
}

// Função para atualizar chamado
public function chamado_atualizar($id = null) {
    $this->check_login();
    
    if (!$id) {
        $this->session->set_flashdata('error', 'ID do chamado não fornecido');
        redirect('chamado');
        return;
    }

    if ($this->input->post()) {
        $dados = [
            'titulo' => $this->input->post('titulo'),
            'descricao' => $this->input->post('descricao'),
            'prioridade' => $this->input->post('prioridade'),
            'status' => $this->input->post('status')
        ];

        if ($this->M_cadastro->chamado_atualizar($id, $dados)) {
            $this->session->set_flashdata('success', 'Chamado atualizado com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao atualizar o chamado.');
        }

        redirect('chamado/visualizar/'.$id);
    }

    // Se não for POST, redireciona para a listagem
    redirect('chamado');
}

// Função para visualizar chamado
public function chamado_visualizar($id) {
  $this->check_login();
  $data['chamado'] = $this->M_cadastro->chamado_obter_por_id($id);
  $this->load_page('chamado/visualizar', $data);
}

// Função para listar chamados do usuário
public function chamado_meus_chamados() {
  $this->check_login();
  $ime = $this->session->userdata('ime');
  $data['chamados'] = $this->M_cadastro->chamado_listar_por_usuario($ime);
  $this->load_page('chamado/meus_chamados', $data);
}




  public function form_20() {
    $this->check_login();
    
    // Obtém o IME do usuário logado
    $ime = $this->session->userdata('ime');
    
    // Busca os dados do usuário
    $dados = $this->M_cadastro->buscar_usuario_por_ime($ime);
    
    // Passa os dados para a view
    $this->load_page('cadastros/form_20', ['dados' => $dados]);
}

  public function setgrau() {
    // Obtém o grau enviado via POST e converte para inteiro
    $grau = (int) $this->input->post('grau'); 
    // Obtém o IME do usuário logado na sessão
    $ime = $this->session->userdata('ime');

    if (!empty($grau) && !empty($ime)) { 
        // Verifica se o usuário tem acesso ao grau
        $temAcesso = $this->M_cadastro->usuario_tem_acesso_ao_grau($ime, $grau);
        
        if ($temAcesso) {
            // Busca os conteúdos do grau específico
            $conteudos = $this->M_cadastro->listar_conteudos_iead($grau);
            
            // Define o caminho da view
            $view_path = APPPATH . "views/iead/$grau.php"; 
            
            // Verifica se a view existe
            if (file_exists($view_path)) {
                // Passa os conteúdos para a view
                $data['conteudos'] = $conteudos;
                $this->load->view("iead/$grau", $data); 
            } else {
                show_404(); 
            }
        } else {
            echo "Acesso negado. Você não tem permissão para visualizar esse grau.";
        }
    } else {
        echo "Nenhum grau válido foi enviado ou usuário não autenticado.";
    }
}


public function buscar_por_ime($ime) {
  // Verifica se o IME foi fornecido
  if (empty($ime)) {
      return $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode(['error' => 'IME não fornecido']));
  }

  // Busca os dados do usuário
  $dados = $this->M_cadastro->buscar_usuario_por_ime($ime);
  
  if (!$dados) {
      return $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode(['error' => 'IME não encontrado']));
  }

  // Mapeamento dos campos de graus
  $graus = [
      4, 5, 7, 9, 10, 14, 15, 16, 17, 18, 
      19, 22, 29, 30, 31, 32, 33
  ];

  // Estrutura base da resposta
  $response = [
      // Dados pessoais
      'id_registro'       => $dados['id_registro'] ?? '',
      'ime_num'           => $dados['ime_num'] ?? '',
      'cadastro'          => $dados['cadastro'] ?? '',
      'email'             => $dados['email'] ?? '',
      'pai'               => $dados['pai'] ?? '',
      'mae'               => $dados['mae'] ?? '',
      'nascimento'        => isset($dados['nascimento']) ? date('d/m/Y', strtotime($dados['nascimento'])) : '',
      'cidade1'           => $dados['cidade1'] ?? '',
      'estado1'           => $dados['estado1'] ?? '',
      'nacionalidade'     => $dados['nacionalidade'] ?? '',
      'profissao'         => $dados['profissao'] ?? '',
      
      // Contato e endereço
      'endereco_residencial' => $dados['endereco_residencial'] ?? '',
      'bairro'            => $dados['bairro'] ?? '',
      'cidade'            => $dados['cidade'] ?? '',
      'estado'            => $dados['estado'] ?? '',
      'cep'               => $dados['cep'] ?? '',
      'telefone_residencial' => $dados['telefone_residencial'] ?? '',
      'telefone_comercial' => $dados['telefone_comercial'] ?? '',
      'celular'           => $dados['celular'] ?? '',
      
      // Dados familiares
      'estado_civil'      => $dados['estado_civil'] ?? '',
      'numero_filhos'     => $dados['numero_filhos'] ?? 0,
      'sexo_m'            => $dados['sexo_m'] ?? '',
      'sexo_f'            => $dados['sexo_f'] ?? '',
      'esposa'            => $dados['esposa'] ?? '',
      'nascida'           => $dados['nascida'] ?? '',
      'casamento'         => isset($dados['casamento']) ? date('d/m/Y', strtotime($dados['casamento'])) : '',
      
      // Documentos
      'rg'                => $dados['rg'] ?? '',
      'orgao_expedidor'   => $dados['orgao_expedidor'] ?? '',
      'cic'               => isset($dados['cic']) ? substr($dados['cic'], 0, 3) . '.' . 
                                                    substr($dados['cic'], 3, 3) . '.' . 
                                                    substr($dados['cic'], 6, 3) . '-' . 
                                                    substr($dados['cic'], 9, 2) : '',
      
      // Dados maçônicos
      'iniciado_loja'     => isset($dados['iniciado_loja']) ? date('d/m/Y', strtotime($dados['iniciado_loja'])) : '',
      'numero_loja'       => $dados['numero_loja'] ?? '',
      'cidade2'           => $dados['cidade2'] ?? '',
      'estado2'           => $dados['estado2'] ?? '',
      'potencia_inicial'  => $dados['potencia_inicial'] ?? '',
      'membro_ativo_loja' => $dados['membro_ativo_loja'] ?? '',
      'numero_da_loja'    => $dados['numero_da_loja'] ?? '',
      'cidade3'           => $dados['cidade3'] ?? '',
      'estado3'           => $dados['estado3'] ?? '',
      'cgo_num'           => $dados['cgo_num'] ?? '',
      'apr_em'            => isset($dados['apr_em']) ? date('d/m/Y', strtotime($dados['apr_em'])) : '',
      'comp_em'           => isset($dados['comp_em']) ? date('d/m/Y', strtotime($dados['comp_em'])) : '',
      'mest_em'           => isset($dados['mest_em']) ? date('d/m/Y', strtotime($dados['mest_em'])) : '',
      'mi_em'             => isset($dados['mi_em']) ? date('d/m/Y', strtotime($dados['mi_em'])) : '',
      'potencia_corpo_filosofico' => $dados['potencia_corpo_filosofico'] ?? '',
      'codigo'            => $dados['codigo'] ?? '',
      'tipo_categoria'    => $dados['tipo_categoria'] ?? '',
      'ativo_no_grau'     => $dados['ativo_no_grau'] ?? 1
  ];

  // Adiciona os dados de graus
  foreach ($graus as $grau) {
      $col_corpo = $this->get_col_corpo_field($grau);
      $tipo_documento = $this->get_tipo_documento($grau);
      
      $response["grau_{$grau}_em"] = isset($dados["grau_{$grau}_em"]) ? date('d/m/Y', strtotime($dados["grau_{$grau}_em"])) : '';
      $response[$col_corpo] = $dados[$col_corpo] ?? '';
      $response["{$tipo_documento}_{$grau}_num"] = $dados["{$tipo_documento}_{$grau}_num"] ?? '';
  }

  return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
}

// Função para gera o pdf da ficha 20
public function gerar_pdf() {
  $this->check_login();

  $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  
  // Configurações do documento
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Supremo Conselho');
  $pdf->SetTitle('Cadastro Maçônico');
  $pdf->SetMargins(15, 15, 15);
  $pdf->AddPage();

  // Caminho para a logo
  $logo_path = FCPATH . 'assets/images/logo_delit_curitiba.png';
  
  // Verifica se o arquivo existe
  if (!file_exists($logo_path)) {
      log_message('error', 'Logo não encontrada em: ' . $logo_path);
  }
  
  // Construir conteúdo HTML
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
      .small-text {
          font-size: 8pt;
      }
      .section {
          background-color: #f0f0f0;
          font-weight: bold;
          padding: 3px;
          margin: 5px 0;
      }
    .table-padding > tbody > tr > td {
          padding: 2px;
          margin-bottom: 5px;
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
              Delegacia Litúrgica Sul-Paraná - 20.1 - CADASTRO.
          </td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="15%">Registro: '.$this->input->post('id_registro').'</td>
          <td width="85%">Nome: '.$this->input->post('cadastro').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="20%">IME nº: '.$this->input->post('ime_num').'</td>
          <td width="20%">CGOnº: '.$this->input->post('cgo_num').'</td>
          <td width="35%">email: '.$this->input->post('email').'</td>
          <td width="25%">RG: '.$this->input->post('rg').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="33%">F.Req.: '.$this->input->post('f_req').'</td>
          <td width="33%">F.Com.: '.$this->input->post('f_com').'</td>
          <td width="34%">Cel.: '.$this->input->post('celular').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="15%">Pai: '.$this->input->post('pai').'</td>
          <td width="85%">Mãe: '.$this->input->post('mae').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="20%">Nasc.: '.$this->input->post('nascimento').'</td>
          <td width="50%">Cidade: '.$this->input->post('cidade').'</td>
          <td width="30%">Estado: '.$this->input->post('estado').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="25%">Nacionalidade: '.$this->input->post('nacionalidade').'</td>
          <td width="45%">Profissão: '.$this->input->post('profissao').'</td>
          <td width="30%">CPF: '.$this->input->post('cpf').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="70%">End.Res.: '.$this->input->post('endereco_residencial').'</td>
          <td width="30%">Bairro: '.$this->input->post('bairro').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="70%">Cidade: '.$this->input->post('cidade').'</td>
          <td width="15%">Estado: '.$this->input->post('estado').'</td>
          <td width="15%">CEP: '.$this->input->post('cep').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="25%">Estado Civil: '.$this->input->post('estado_civil').'</td>
          <td width="15%">NºFilhos: '.$this->input->post('numero_filhos').'</td>
          <td width="15%">M: '.$this->input->post('sexo_m').'</td>
          <td width="15%">F: '.$this->input->post('sexo_f').'</td>
          <td width="30%">Casamento: '.$this->input->post('casamento').'</td>
      </tr>
  </table>
  <br>
  <div class="section">TESOURARIA</div>
  <table border="1" cellpadding="2">
      <tr>
          <td width="33%">Iniciado Loja: '.$this->input->post('iniciado_loja').'</td>
          <td width="33%">Nº: '.$this->input->post('numero_loja').'</td>
          <td width="34%">Pot.Iniciado: '.$this->input->post('potencia_inicial').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="33%">Ativo:Loja: '.$this->input->post('membro_ativo_loja').'</td>
          <td width="33%">Nº: '.$this->input->post('numero_da_loja').'</td>
          <td width="34%">Oriente: '.$this->input->post('oriente').'</td>
      </tr>
  </table>

  <table border="1" cellpadding="2">
      <tr>
          <td width="33%">Apr.Em: '.$this->input->post('apr_em').'</td>
          <td width="33%">Comp.Em: '.$this->input->post('comp_em').'</td>
          <td width="34%">Mest.Em: '.$this->input->post('mest_em').'</td>
      </tr>
  </table>
  <br>
  <div class="section">Corpo Filos.:Cap. Rosa Cruz Fard da Esperança</div>';

  // Array com os graus e seus respectivos números de coluna
  $graus = [
      ['grau' => 4, 'coluna' => 1],
      ['grau' => 7, 'coluna' => 14],
      ['grau' => 9, 'coluna' => 2],
      ['grau' => 10, 'coluna' => 3],
      ['grau' => 14, 'coluna' => 4],
      ['grau' => 15, 'coluna' => 5],
      ['grau' => 16, 'coluna' => 15],
      ['grau' => 17, 'coluna' => 16],
      ['grau' => 18, 'coluna' => 6]
  ];

  foreach ($graus as $info) {
      $grau = $info['grau'];
      $coluna = $info['coluna'];
      
      if ($this->input->post("grau_{$grau}_em")) {
          $html .= '
          <table border="1" class="table-padding" cellpadding="2">
              <tr>
                  <td width="33%">Grau'.$grau.'Em: '.$this->input->post("grau_{$grau}_em").'</td>
                  <td width="33%">Colou: '.$this->input->post("col_corpo_{$coluna}").'</td>
                  <td width="34%">Diploma'.$grau.'Nº: '.$this->input->post("diploma_{$grau}_num").'</td>
              </tr>
          </table>';
      }
  }

  $html .= '
  <div style="margin-top:20px; text-align:center;" class="small-text">
      R: Mal. Deodoro, 502 - 7º andar - Sala 710-Centro-Curitiba-PR-80010-010 - Fone (41) 3222-5178 - e-mail: delitsulpr@gmail.com
  </div>';

  $pdf->writeHTML($html, true, false, true, false, '');
  $pdf->Output('cadastro_maconico_'.$this->input->post('ime_num').'.pdf', 'D');
}

// Funções auxiliares
private function get_col_corpo_field($grau) {
  $mapping = [
      4 => 'col_corpo_1',
      5 => 'col_corpo_05',
      7 => 'col_corpo_14',
      9 => 'col_corpo_2',
      10 => 'col_corpo_3',
      14 => 'col_corpo_4',
      15 => 'col_corpo_5',
      16 => 'col_corpo_15',
      17 => 'col_corpo_16',
      18 => 'col_corpo_6',
      19 => 'col_corpo_7',
      22 => 'col_corpo_8',
      29 => 'col_corpo_9',
      30 => 'col_corpo_10',
      31 => 'col_corpo_11',
      32 => 'col_corpo_12',
      33 => 'col_corpo_13'
  ];
  
  return $mapping[$grau] ?? 'col_corpo_'.$grau;
}

private function get_tipo_documento($grau) {
  if ($grau >= 30) return 'patente';
  if ($grau == 18) return 'breve';
  return 'diploma';
}
public function gerenciar_conteudos_iead() {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  $data['conteudos'] = $this->M_cadastro->listar_conteudos_iead();
  $this->load_page('gerenciar_conteudos_iead', $data);
}

public function criar_conteudo_iead() {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  if ($this->input->post()) {
      $config['upload_path'] = './uploads/iead/';
      $config['allowed_types'] = 'mp4|jpg|jpeg|png|pdf|txt|docx';
      $config['max_size'] = 802400; // 100MB

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('arquivo')) {
          $upload_data = $this->upload->data();
          $dados = [
              'titulo' => $this->input->post('titulo'),
              'descricao' => $this->input->post('descricao'),
              'grau' => $this->input->post('grau'),
              'tipo_conteudo' => $this->input->post('tipo_conteudo'),
              'caminho_arquivo' => 'uploads/iead/' . $upload_data['file_name']
          ];

          if ($this->M_cadastro->inserir_conteudo_iead($dados)) {
              $this->session->set_flashdata('success', 'Conteúdo salvo com sucesso!');
              redirect('controlador/gerenciar_conteudos_iead');
              return;
          } else {
              $this->session->set_flashdata('error', 'Erro ao salvar o conteúdo no banco de dados.');
          }
      } else {
          $this->session->set_flashdata('error', $this->upload->display_errors());
      }
      
      redirect('controlador/gerenciar_conteudos_iead');
      return;
  }

  $this->load_page('form_conteudo_iead');
}

public function editar_conteudo_iead($id) {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  if ($this->input->post()) {
      $dados = [
          'titulo' => $this->input->post('titulo'),
          'descricao' => $this->input->post('descricao'),
          'grau' => $this->input->post('grau'),
          'tipo_conteudo' => $this->input->post('tipo_conteudo')
      ];

      if ($_FILES['arquivo']['name']) {
          $config['upload_path'] = './uploads/iead/';
          $config['allowed_types'] = 'mp4|jpg|jpeg|png|pdf|txt|docx';
          $config['max_size'] = 20480; // 20MB

          $this->load->library('upload', $config);

          if ($this->upload->do_upload('arquivo')) {
              $upload_data = $this->upload->data();
              $dados['caminho_arquivo'] = 'uploads/iead/' . $upload_data['file_name'];
          } else {
              $this->session->set_flashdata('error', $this->upload->display_errors());
              redirect('controlador/editar_conteudo_iead/' . $id);
          }
      }

      if ($this->M_cadastro->atualizar_conteudo_iead($id, $dados)) {
          $this->session->set_flashdata('success', 'Conteúdo atualizado com sucesso!');
      } else {
          $this->session->set_flashdata('error', 'Erro ao atualizar o conteúdo.');
      }

      redirect('controlador/gerenciar_conteudos_iead');
  }

  $data['conteudo'] = $this->M_cadastro->obter_conteudo_iead($id);
  $this->load_page('form_conteudo_iead', $data);
}

public function deletar_conteudo_iead($id) {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  $this->M_cadastro->deletar_conteudo_iead($id);
  redirect('controlador/gerenciar_conteudos_iead');
}
public function pagina_nao_encontrada() {
  // Carrega a view 404.php
  $this->load->view('404');
}
public function planilhas() {
  $this->check_login();
  $grau = $this->session->userdata('user_data')['role'] == 'admin' ? null : $this->session->userdata('user_data')['grau_acesso'];
  $data['planilhas'] = $this->M_cadastro->listar_planilhas($grau);
  $this->load_page('planilhas', $data);
}

public function visualizar_planilha($id) {
  $this->check_login();
  $planilha = $this->M_cadastro->obter_planilha($id);
  if ($planilha) {
      $data['planilha'] = $planilha;
      $this->load_page('visualizar_planilha', $data);
  } else {
      show_404();
  }
}
public function adicionar_planilha() {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  if ($this->input->post()) {
      // Configurações para o upload
      $config['upload_path'] = './uploads/planilhas/';
      $config['allowed_types'] = 'pdf'; // Aceita apenas PDF
      $config['max_size'] = 20480; // 20MB
      $config['file_name'] = uniqid(); // Nome único para o arquivo

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('arquivo')) {
          $upload_data = $this->upload->data();
          $dados = [
              'nome' => $this->input->post('nome'),
              'caminho' => 'uploads/planilhas/' . $upload_data['file_name'],
              'grau_acesso' => $this->input->post('grau_acesso')
          ];

          if ($this->M_cadastro->inserir_planilha($dados)) {
              $this->session->set_flashdata('success', 'Arquivo PDF adicionado com sucesso!');
          } else {
              $this->session->set_flashdata('error', 'Erro ao salvar o arquivo no banco de dados.');
          }
      } else {
          $this->session->set_flashdata('error', $this->upload->display_errors());
      }

      redirect('controlador/planilhas');
  }

  $this->load_page('form_planilha');
}


public function editar_planilha($id) {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  if ($this->input->post()) {
      $dados = [
          'nome' => $this->input->post('nome'),
          'grau_acesso' => $this->input->post('grau_acesso')
      ];

      // Verifica se um novo arquivo foi enviado
      if (!empty($_FILES['arquivo']['name'])) {
          $config['upload_path'] = './uploads/planilhas/';
          $config['allowed_types'] = 'pdf'; // Aceita apenas PDF
          $config['max_size'] = 20480; // 20MB
          $config['file_name'] = uniqid(); // Nome único para o arquivo

          $this->load->library('upload', $config);

          if ($this->upload->do_upload('arquivo')) {
              $upload_data = $this->upload->data();
              $dados['caminho'] = 'uploads/planilhas/' . $upload_data['file_name'];

              // Remove o arquivo antigo, se existir
              $planilha_antiga = $this->M_cadastro->obter_planilha($id);
              if (!empty($planilha_antiga['caminho']) && file_exists($planilha_antiga['caminho'])) {
                  unlink($planilha_antiga['caminho']);
              }
          } else {
              $this->session->set_flashdata('error', $this->upload->display_errors());
              redirect('controlador/editar_planilha/' . $id);
          }
      }

      if ($this->M_cadastro->atualizar_planilha($id, $dados)) {
          $this->session->set_flashdata('success', 'Arquivo PDF atualizado com sucesso!');
      } else {
          $this->session->set_flashdata('error', 'Erro ao atualizar o arquivo.');
      }

      redirect('controlador/planilhas');
  }

  $data['planilha'] = $this->M_cadastro->obter_planilha($id);
  $this->load_page('form_planilha', $data);
}

public function deletar_planilha($id) {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  $this->M_cadastro->deletar_planilha($id);
  redirect('controlador/planilhas');
}

/**
 * Gerencia o cadastro de novos usuários (Passo 1)
 * Apenas admins podem cadastrar usuários
 */
public function cadastrar_usuario() {
    $this->check_login();

    if ($this->session->userdata('user_data')['role'] !== 'admin') {
        $this->session->set_flashdata('error', 'Acesso negado. Apenas administradores podem cadastrar usuários.');
        redirect('controlador/dashboard');
    }

    // Busca o último IME cadastrado
    $data['ultimo_ime'] = $this->M_cadastro->obter_ultimo_ime();

    $this->form_validation->set_rules('ime', 'IME', 'required|callback_validar_ime', [
        'required' => 'O campo IME é obrigatório',
        'validar_ime' => 'IME inválido ou já cadastrado'
    ]);
    
    $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]', [
        'required' => 'O campo Nome é obrigatório',
        'min_length' => 'O nome deve ter pelo menos 5 caracteres'
    ]);
    
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[usuarios.email]', [
        'required' => 'O campo Email é obrigatório',
        'valid_email' => 'Digite um email válido',
        'is_unique' => 'Este email já está cadastrado'
    ]);
    
    $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[6]', [
        'required' => 'O campo Senha é obrigatório',
        'min_length' => 'A senha deve ter pelo menos 6 caracteres'
    ]);
    
    $this->form_validation->set_rules('confirma_senha', 'Confirmação de Senha', 'required|matches[senha]', [
        'required' => 'Confirme sua senha',
        'matches' => 'As senhas não conferem'
    ]);

    if ($this->form_validation->run() === FALSE) {
        $this->load_page('cadastrar_usuario', $data);
    } else {
        $ime = $this->input->post('ime');
        $senha_original = $this->input->post('senha'); // Salva a senha original
        
        $dados = [
            'ime' => $ime,
            'nome' => $this->input->post('nome'),
            'email' => $this->input->post('email'),
            'senha' => md5($senha_original), // Criptografa a senha para o banco
            'role' => $this->input->post('role', 'usuario'),
            'status' => 'ativo',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $usuario_id = $this->M_cadastro->inserir_usuario($dados);
        
        if ($usuario_id) {
            // Salva a senha original na sessão para usar no email final
            $this->session->set_userdata('senha_original', $senha_original);
            
            $this->session->set_flashdata('success', 'Usuário cadastrado com sucesso! Continue o cadastro.');
            redirect('controlador/cadastrar_pk_usuario/' . $dados['ime']);
        } else {
            $this->session->set_flashdata('error', 'Erro ao cadastrar usuário.');
            redirect('controlador/cadastrar_usuario');
        }
    }
}

/**
 * Valida o formato do IME
 */
public function validar_ime($ime) {
    // Remove espaços em branco
    $ime = trim($ime);
    
    // Verifica se tem exatamente um ponto
    if (substr_count($ime, '.') !== 1) {
        return FALSE;
    }
    
    // Verifica se está no formato correto (XXX.XXX)
    if (!preg_match('/^\d{3}\.\d{3}$/', $ime)) {
        return FALSE;
    }
    
    // Verifica se já existe no banco
    $existe = $this->M_cadastro->verificar_ime_existe($ime);
    
    return !$existe;
}

/**
 * Gerencia o cadastro dos dados complementares (Passo 2)
 */
public function cadastrar_pk_usuario($ime) {
    $this->check_login();

    if ($this->session->userdata('user_data')['role'] !== 'admin') {
        show_404();
    }

    // Configurar regras de validação
    $this->form_validation->set_rules('cic', 'CPF', 'required|callback_validar_cpf|is_unique[pk_usuarios.cic]', [
        'required' => 'O campo CPF é obrigatório',
        'validar_cpf' => 'CPF inválido',
        'is_unique' => 'Este CPF já está cadastrado'
    ]);
    
    // Se for POST, salva os dados na sessão
    if ($this->input->post()) {
        $form_data = $this->input->post();
        $this->session->set_userdata('pk_usuario_form', $form_data);
    }
    
    if ($this->form_validation->run() === FALSE) {
        // Busca dados do usuário
        $data['usuario'] = $this->M_cadastro->obter_usuario_por_ime($ime);
        
        // Recupera dados da sessão se existirem
        $data['form_data'] = $this->session->userdata('pk_usuario_form');
        
        $this->load_page('form_pk_usuario', $data);
    } else {
        // Inicia uma transação
        $this->db->trans_start();

        try {
            // Dados para pk_usuarios
            $dados = [
                'ime_num' => $ime,
                'cadastro' => $this->input->post('cadastro'),
                'cic' => preg_replace('/[^0-9]/', '', $this->input->post('cic')), // Remove caracteres não numéricos
                'email' => $this->input->post('email'),
                'ativo_no_grau' => $this->input->post('ativo_no_grau', 1), // Valor padrão 1
                // ... outros campos ...
            ];

            // Insere na tabela pk_usuarios
            if (!$this->M_cadastro->inserir_pk_usuario($dados)) {
                throw new Exception('Erro ao salvar dados complementares.');
            }

            // Atualiza dados na tabela usuarios
            $dados_usuario = [
                'grau' => $dados['ativo_no_grau'],
                'email' => $dados['email'],
                'cpf' => $dados['cic'] // Mesmo CPF, campo com nome diferente
            ];
            
            if (!$this->db->where('ime', $ime)->update('usuarios', $dados_usuario)) {
                throw new Exception('Erro ao atualizar o usuário.');
            }

            // Completa a transação
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Erro na transação do banco de dados.');
            }

            // Limpa os dados da sessão após salvar com sucesso
            $this->session->unset_userdata('pk_usuario_form');
            
            // Busca os dados completos do usuário
            $usuario = $this->M_cadastro->obter_usuario_por_ime($ime);
            
            // Busca a senha original da sessão
            $senha_original = $this->session->userdata('senha_original');
            
            // Envia o email com as credenciais
            $assunto = '📬 Cadastro Concluído - Portal Delit Curitiba';
            
            $corpo = "
                    <div style='padding: 20px; background-color: #f9f9f9;'>
                        <h2 style='color:#960018;'>Olá, {$usuario['nome']}!</h2>
                        <p>Seu cadastro no sistema foi concluído com sucesso.</p>
                        
                        <div style='background-color: #e9ecef; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                            <h3 style='color: #960018; margin-top: 0;'>Seus dados de acesso:</h3>
                            <p><strong>IME (CIM):</strong> {$ime}</p>
                            <p><strong>Email:</strong> {$usuario['email']}</p>
                            <p><strong>Senha:</strong> {$senha_original}</p>
                        </div>
                        
                        <p style='margin-bottom: 20px;'>Para acessar o sistema, clique no botão abaixo:</p>
                        
                        <a href='".base_url()."' 
                           style='display: inline-block; background-color: #960018; color: #ffffff; 
                                  padding: 10px 20px; text-decoration: none; border-radius: 5px; 
                                  font-weight: bold;'>
                            Acessar o Portal
                        </a>
                        
                        <p style='margin-top: 20px;'>
                            Por favor, mantenha suas credenciais em segurança e não as compartilhe com ninguém.
                        </p>
                    </div>
                    
                    <div style='text-align: center; padding: 15px; background-color: #e9ecef; 
                               font-size: 12px; color: #666;'>
                        <p>© ".date('Y')." Delit Curitiba. Todos os direitos reservados.</p>
                        <p>Este é um e-mail automático, por favor não responda.</p>
                    </div>
                </div>
            ";
            
            try {
                $enviado = $this->M_email->enviar_email($usuario['email'], $assunto, $corpo);
                
                if ($enviado) {
                    $this->session->set_flashdata('success', 
                        'Cadastro complementar realizado com sucesso! Um email foi enviado com as credenciais.');
                } else {
                    $this->session->set_flashdata('warning', 
                        'Cadastro realizado, mas houve um erro ao enviar o email. Por favor, informe as credenciais ao usuário.');
                    log_message('error', 'Falha ao enviar e-mail de cadastro para: '.$usuario['email']);
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('warning', 
                    'Cadastro realizado, mas houve um erro ao enviar o email. Por favor, informe as credenciais ao usuário.');
                log_message('error', 'Erro ao enviar e-mail: '.$e->getMessage());
            }
            
            // Limpa a senha original da sessão
            $this->session->unset_userdata('senha_original');
            
            redirect('controlador/listar_usuarios');

        } catch (Exception $e) {
            // Se houver erro, reverte a transação
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('controlador/cadastrar_pk_usuario/' . $ime);
        }
    }
}

/**
 * Valida CPF
 */
public function validar_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return FALSE;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return FALSE;
        }
    }
    return TRUE;
}

/**
 * Valida data
 */
public function validar_data($data) {
    $data = explode('-', $data);
    if (count($data) != 3) {
        return FALSE;
    }
    return checkdate($data[1], $data[2], $data[0]);
}

public function deletar_usuario($ime) {
  $this->check_login();

  // Verifica se o usuário tem permissão para deletar
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  // Deleta o usuário
  $this->M_cadastro->deletar_usuario_por_ime($ime);


  // Mensagem de sucesso
  $this->session->set_flashdata('success', 'Usuário deletado com sucesso!');

  // Redireciona para a listagem de usuários
  redirect('controlador/listar_usuarios');
}


/**
 * Lista todos os usuários do sistema com paginação e filtros
 * Apenas admins podem acessar
 */
public function listar_usuarios() {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  // Filtros
  $filtros = [];
  if ($this->input->get('nome')) {
      $filtros['nome'] = $this->input->get('nome');
  }
  if ($this->input->get('ime')) {
      $filtros['ime'] = $this->input->get('ime');
  }
  if ($this->input->get('grau')) {
      $filtros['grau'] = $this->input->get('grau');
  }

  // Configuração da paginação
  $this->load->library('pagination');

  $config['base_url'] = base_url('controlador/listar_usuarios');
  $config['total_rows'] = $this->M_cadastro->contar_usuarios($filtros); // Total de registros
  $config['per_page'] = 100; // Quantidade de registros por página
  $config['uri_segment'] = 3; // Segmento da URL que contém o número da página

  // Estilo da paginação
  $config['full_tag_open'] = '<ul class="pagination">';
  $config['full_tag_close'] = '</ul>';
  $config['first_link'] = 'Primeira';
  $config['last_link'] = 'Última';
  $config['first_tag_open'] = '<li class="page-item">';
  $config['first_tag_close'] = '</li>';
  $config['prev_link'] = '&laquo';
  $config['prev_tag_open'] = '<li class="page-item">';
  $config['prev_tag_close'] = '</li>';
  $config['next_link'] = '&raquo';
  $config['next_tag_open'] = '<li class="page-item">';
  $config['next_tag_close'] = '</li>';
  $config['last_tag_open'] = '<li class="page-item">';
  $config['last_tag_close'] = '</li>';
  $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
  $config['cur_tag_close'] = '</a></li>';
  $config['num_tag_open'] = '<li class="page-item">';
  $config['num_tag_close'] = '</li>';
  $config['attributes'] = ['class' => 'page-link'];

  $this->pagination->initialize($config);

  // Obter o número da página atual
  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

  // Buscar os usuários com paginação
  $data['usuarios'] = $this->M_cadastro->listar_usuarios($filtros, $config['per_page'], $page);
  $data['pagination'] = $this->pagination->create_links();
  $data['total_usuarios'] = $config['total_rows'];

  // Carregar a view
  $this->load_page('listar_usuarios', $data);
}


/**
 * Exibe formulário para edição de usuário
 * @param string $ime IME do usuário
 */
public function editar_usuario($ime) {
  $this->check_login();
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  // Busca os dados do usuário e pk_usuarios
  $data['usuario'] = $this->M_cadastro->obter_usuario_por_ime($ime); // Busca pelo IME
  $data['pk_usuario'] = $this->M_cadastro->obter_pk_usuario_por_ime($ime); // Busca pelo IME

  // Carrega a view de edição
  $this->load_page('editar_usuario', $data);
}


public function salvar_edicao_usuario($id) {
  $this->check_login();
    
  // Verifica se o usuário tem permissão para editar
  if ($this->session->userdata('user_data')['role'] !== 'admin') {
      show_404();
  }

  if ($this->input->post()) {
      // Inicia uma transação para garantir a integridade dos dados
      $this->db->trans_start();

      try {
          // Obtém os dados do formulário
          $dados_usuario = $this->getDadosUsuario();
          $dados_pk_usuario = $this->getDadosPkUsuario();

          // Atualiza os dados na tabela usuarios
          if (!$this->atualizarUsuario($id, $dados_usuario)) {
              throw new Exception('Erro ao atualizar os dados do usuário.');
          }
          
          // Atualiza os dados na tabela pk_usuarios
          if (!$this->atualizarPkUsuario($this->input->post('ime_num'), $dados_pk_usuario)) {
              throw new Exception('Erro ao atualizar os dados do PK do usuário.');
          }
          
          // Conclui a transação
          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE) {
              throw new Exception('Erro ao finalizar a transação.');
          }

          $this->session->set_flashdata('success', 'Usuário atualizado com sucesso!');
      } catch (Exception $e) {
          // Se ocorrer um erro, reverte todas as alterações no banco de dados
          $this->db->trans_rollback();
          log_message('error', 'Erro ao salvar edição do usuário: ' . $e->getMessage());
          $this->session->set_flashdata('error', $e->getMessage());
      }

      redirect('controlador/listar_usuarios');
  }
}

// Método para obter dados do usuário
private function getDadosUsuario() {
  return [
      'nome' => $this->input->post('nome'),
      'email' => $this->input->post('email'),
      'role' => $this->input->post('role'),
      'grau' => $this->input->post('ativo_no_grau')
  ];
}

// Método para obter dados de pk_usuarios
private function getDadosPkUsuario() {
  return [
      'cadastro' => $this->input->post('cadastro'),
      'pai' => $this->input->post('pai'),
      'mae' => $this->input->post('mae'),
      'nascimento' => $this->input->post('nascimento'),
      'cidade1' => $this->input->post('cidade1'),
      'estado1' => $this->input->post('estado1'),
      'nacionalidade' => $this->input->post('nacionalidade'),
      'profissao' => $this->input->post('profissao'),
      'endereco_residencial' => $this->input->post('endereco_residencial'),
      'bairro' => $this->input->post('bairro'),
      'cidade' => $this->input->post('cidade'),
      'estado' => $this->input->post('estado'),
      'cep' => $this->input->post('cep'),
      'telefone_residencial' => $this->input->post('telefone_residencial'),
      'telefone_comercial' => $this->input->post('telefone_comercial'),
      'celular' => $this->input->post('celular'),
      'estado_civil' => $this->input->post('estado_civil'),
      'numero_filhos' => $this->input->post('numero_filhos'),
      'sexo_m' => $this->input->post('sexo_m'),
      'sexo_f' => $this->input->post('sexo_f'),
      'esposa' => $this->input->post('esposa'),
      'nascida' => $this->input->post('nascida'),
      'casamento' => $this->input->post('casamento'),
      // ... outros campos ...
  ];
}

// Método para atualizar a tabela usuarios
private function atualizarUsuario($id, $dados) {
  return $this->db->where('id', $id)->update('usuarios', $dados);
}

// Método para atualizar a tabela pk_usuarios
private function atualizarPkUsuario($ime_num, $dados) {
  return $this->db->where('ime_num', $ime_num)->update('pk_usuarios', $dados);
}

/**
 * Processa o streaming de vídeos do sistema
 * Implementa suporte a ranges para streaming parcial
 * @param int $id ID do conteúdo de vídeo
 */
public function servir_video($id) {
    $this->check_login();
    
    // Busca o conteúdo pelo ID
    $conteudo = $this->M_cadastro->obter_conteudo_iead($id);
    
    if (!$conteudo || $conteudo['tipo_conteudo'] !== 'video') {
        show_404();
        return;
    }
    
    // Verifica se o usuário tem acesso ao grau do conteúdo
    $ime = $this->session->userdata('ime');
    if (!$this->M_cadastro->usuario_tem_acesso_ao_grau($ime, $conteudo['grau'])) {
        show_404();
        return;
    }
    
    $caminho_arquivo = FCPATH . $conteudo['caminho_arquivo'];
    
    if (!file_exists($caminho_arquivo)) {
        show_404();
        return;
    }
    
    // Configuração para streaming de vídeo
    $fp = @fopen($caminho_arquivo, 'rb');
    $size = filesize($caminho_arquivo);
    $length = $size;
    $start = 0;
    $end = $size - 1;
    
    header('Content-Type: video/mp4');
    header('Accept-Ranges: bytes');
    
    // Suporte para streaming parcial
    if (isset($_SERVER['HTTP_RANGE'])) {
        $c_start = $start;
        $c_end = $end;
        
        list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
        if (strpos($range, ',') !== false) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$size");
            exit;
        }
        
        if ($range == '-') {
            $c_start = $size - substr($range, 1);
        } else {
            $range = explode('-', $range);
            $c_start = $range[0];
            $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
        }
        
        $c_end = ($c_end > $end) ? $end : $c_end;
        if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$size");
            exit;
        }
        
        $start = $c_start;
        $end = $c_end;
        $length = $end - $start + 1;
        fseek($fp, $start);
        header('HTTP/1.1 206 Partial Content');
    }
    
    // Headers de segurança
    header("Content-Range: bytes $start-$end/$size");
    header('Content-Length: ' . $length);
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    
    // Envia o vídeo em chunks para melhor performance
    $buffer = 1024 * 8;
    while (!feof($fp) && ($p = ftell($fp)) <= $end) {
        if ($p + $buffer > $end) {
            $buffer = $end - $p + 1;
        }
        echo fread($fp, $buffer);
        flush();
    }
    
    fclose($fp);
    exit;
}

}
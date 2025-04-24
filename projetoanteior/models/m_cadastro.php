<?php
class M_cadastro extends CI_Model {
  //Liberação de variaveis 
  public $usuario;
  public $email;
  public $senha;
  public $conf_senha;
  public $referencia;
  public $forum_id;
  
  public function __construct() {
    parent::__construct();

  }
  
  public function validate_login($ime, $senha) {
    $this->db->where('ime', $ime);
    $this->db->where('senha', md5($senha)); // Convertendo senha para MD5
    $query = $this->db->get('usuarios');
    return $query->row_array();
  }

  public function buscar_usuario_por_ime($ime) {
    return $this->db->get_where('pk_usuarios', ['ime_num' => $ime])->row_array();

  }
  public function buscar_todos_os_dados_tb_usuario($ime) {
    return $this->db->get_where('usuarios', ['ime' => $ime])->row_array();
}

  
  public function verifica_acesso_grau($ime, $grau) {

    $this->db->where('ime_num', $ime);
    $this->db->where('ativo_no_grau', $grau);
    $query = $this->db->get('pk_usuarios'); // Supondo que essa seja a tabela que relaciona usuários e graus

    return $query->num_rows() > 0; // Retorna verdadeiro se o usuário tem acesso ao grau
}

public function usuario_tem_acesso_ao_grau($ime, $grau) {
  // Obtém o maior grau que o usuário possui
  $this->db->select_max('ativo_no_grau');
  $this->db->where('ime_num', $ime);
  $query = $this->db->get('pk_usuarios');
  
  if ($query->num_rows() > 0) {
      $row = $query->row();
      return $grau <= $row->ativo_no_grau; // Retorna true se o grau enviado for menor ou igual ao do banco
  }
  
  return false; // Retorna false se o usuário não for encontrado
}

  public function get_user_data($ime) {
    // Buscar os dados do usuário pelo IME
    $this->db->where('ime_num', $ime);
    $query = $this->db->get('pk_usuarios');  // Altere para a tabela correta se necessário
    return $query->row_array();
  }
  
  public function inserir_conteudo_iead($dados) {
    return $this->db->insert('iead_conteudos', $dados);
  }

  public function listar_conteudos_iead($grau = null) {

      if ($grau) {
          $this->db->where('grau', $grau);
      }
      return $this->db->get('iead_conteudos')->result_array();
  }

  public function obter_conteudo_iead($id) {
    
      return $this->db->get_where('iead_conteudos', ['id' => $id])->row_array();
  }

  public function atualizar_conteudo_iead($id, $dados) {
      $this->db->where('id', $id);
      return $this->db->update('iead_conteudos', $dados);
  }

  public function deletar_conteudo_iead($id) {
      return $this->db->delete('iead_conteudos', ['id' => $id]);
  }
    
 
  public function listar_planilhas($grau = null) {
    if ($grau) {
        $this->db->where('grau_acesso <=', $grau);
    }
    return $this->db->get('planilhas')->result_array();
}

public function obter_planilha($id) {
    return $this->db->get_where('planilhas', ['id' => $id])->row_array();
}

public function inserir_planilha($dados) {
    return $this->db->insert('planilhas', $dados);
}

public function atualizar_planilha($id, $dados) {
    $this->db->where('id', $id);
    return $this->db->update('planilhas', $dados);
}

public function deletar_planilha($id) {
    return $this->db->delete('planilhas', ['id' => $id]);
}
public function inserir_usuario($dados) {
  // Inserir na tabela usuarios
  $this->db->insert('usuarios', $dados);
  $usuario_id = $this->db->insert_id();

  // Envia e-mail de confirmação
  $this->load->model('M_email');
  
  $assunto = '📬 Cadastro Realizado - Portal Delit Curitiba';
  
  $corpo = "
      <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
          <div style='background-color: #960018; padding: 20px; text-align: center;'>
              <img src='https://delitcuritiba.org/wp-content/uploads/2024/08/logo150x150-1.png' alt='Logo Delit Curitiba' style='max-width: 150px;'>
              <h2 style='color: #ffffff; margin-top: 10px;'>Portal Delit Curitiba</h2>
          </div>
          
          <div style='padding: 20px; background-color: #f9f9f9;'>
              <h2 style='color:#960018;'>Olá, {$dados['nome']}!</h2>
              <p>Seu cadastro no sistema foi realizado com sucesso.</p>
              
              <div style='background-color: #e9ecef; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                  <h3 style='color: #960018; margin-top: 0;'>Seus dados de acesso:</h3>
                  <p><strong>IME (CIM):</strong> {$dados['ime']}</p>
                  <p>Para ter acesso acesso o portal e click em Primeiro Acesso, informe IME e CPF para receber a senha de acesso</p>
              </div>
              
              <p style='margin-bottom: 20px;'>Para acessar o sistema, clique no botão abaixo:</p>
              
              <a href='".base_url()."' style='display: inline-block; background-color: #960018; color: #ffffff; 
                 padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                  Acessar o Portal
              </a>
              
              <p style='margin-top: 20px;'>Caso não tenha feito esse cadastro, por favor ignore este e-mail ou entre em contato conosco.</p>
          </div>
          
          <div style='text-align: center; padding: 15px; background-color: #e9ecef; font-size: 12px; color: #666;'>
              <p>© ".date('Y')." Delit Curitiba. Todos os direitos reservados.</p>
              <p>Este é um e-mail automático, por favor não responda.</p>
          </div>
      </div>
  ";
  
  // Envia o e-mail (com tratamento de erro)
  try {
      $enviado = $this->M_email->enviar_email($dados['email'], $assunto, $corpo);
      
      if (!$enviado) {
          log_message('error', 'Falha ao enviar e-mail de confirmação para: '.$dados['email']);
      }
  } catch (Exception $e) {
      log_message('error', 'Erro ao enviar e-mail: '.$e->getMessage());
  }

  return $usuario_id;
}
  //  SEM E-MAIL 
// public function inserir_usuario($dados) {
//   // Inserir na tabela usuarios
//   $this->db->insert('usuarios', $dados);
//   $usuario_id = $this->db->insert_id();

//   // Inserir na tabela pk_usuarios
//   $pk_dados = [
//       'ime_num' => $dados['ime'], // Usando o mesmo ime
//       'cadastro' => date('Y-m-d'), // Data de cadastro
//       'email' => $dados['email'],
//       'ativo_no_grau' => 1 // Grau inicial
//   ];
//   $this->db->insert('pk_usuarios', $pk_dados);

//   return $usuario_id;
// }

public function inserir_pk_usuario($dados) {
  // Remover campos que não existem na tabela antes de inserir
  $campos_permitidos = array(
    'ime_num', 'cadastro', 'email', 'pai', 'mae', 'nascimento',
    'nacionalidade', 'profissao', 'cic', 'rg', 'orgao_expedidor',
    'endereco_residencial', 'bairro', 'cep', 'cidade', 'estado',
    'telefone_residencial', 'telefone_comercial', 'celular',
    'estado_civil', 'numero_filhos', 'sexo_m', 'sexo_f',
    'esposa', 'nascida', 'casamento',
    'iniciado_loja', 'numero_loja', 'cidade2', 'estado2',
    'potencia_inicial', 'cgo_num', 'membro_ativo_loja',
    'numero_da_loja', 'cidade3', 'estado3', 'potencia_corpo_filosofico',
    'apr_em', 'comp_em', 'mest_em', 'mi_em',
    'ativo_no_grau', 'codigo', 'tipo_categoria',
    // Campos de graus específicos
    'grau_4_em', 'grau_5_em', 'grau_7_em', 'grau_9_em',
    'grau_10_em', 'grau_14_em', 'grau_15_em', 'grau_16_em',
    'grau_17_em', 'grau_18_em', 'grau_30_em',
    // Campos de colegiado
    'col_corpo_4', 'col_corpo_5', 'col_corpo_7', 'col_corpo_9',
    'col_corpo_10', 'col_corpo_14', 'col_corpo_15', 'col_corpo_16',
    'col_corpo_18',
    // Campos de diploma/breve
    'diploma_4_num', 'diploma_5_num', 'diploma_7_num', 'diploma_9_num',
    'diploma_10_num', 'diploma_14_num', 'diploma_15_num', 'diploma_16_num',
    'diploma_17_num', 'breve_18_num', 'patente_30_num',
    // Outros campos
    'condecoracoes_scb', 'pg_corpo_1', 'cond_rec', 'cond_gr_rec',
    'cond_mont', 'ano1', 'rec', 'gr_rec', 'monte'
  );

  // Filtrar apenas os campos que existem
  $dados_filtrados = array_intersect_key($dados, array_flip($campos_permitidos));
  
  return $this->db->insert('pk_usuarios', $dados_filtrados);
}
public function obter_usuario_por_id($id) {
  // Busca o usuário pelo ID na tabela usuarios
  $this->db->where('id', $id);
  $query = $this->db->get('usuarios');
  return $query->row_array();
}


public function obter_usuario_por_ime($ime) {
  $this->db->where('ime', $ime);
  $query = $this->db->get('usuarios');
  return $query->row_array();
}

public function obter_pk_usuario_por_ime($ime) {
  
  $this->db->where('ime_num', $ime);
  $query = $this->db->get('pk_usuarios');
  return $query->row_array();
}


public function deletar_usuario_por_ime($ime) {
  $this->db->where('ime', $ime);
  return $this->db->delete('usuarios');
}
public function deletar_pk_usuario_por_ime($ime) {
  $this->db->where('ime_num', $ime);
  return $this->db->delete('pk_usuarios');
}

public function listar_usuarios($filtros = [], $limit = null, $offset = null) {
  if (!empty($filtros['nome'])) {
      $this->db->like('usuarios.nome', $filtros['nome']);
  }
  if (!empty($filtros['ime'])) {
      $this->db->where('usuarios.ime', $filtros['ime']);
  }
  if (!empty($filtros['grau'])) {
      $this->db->where('pk_usuarios.ativo_no_grau', $filtros['grau']);
  }

  // Aplicar limite e offset para paginação
  if ($limit !== null) {
      $this->db->limit($limit, $offset);
  }

  $this->db->select('usuarios.*, pk_usuarios.ativo_no_grau as grau');
  $this->db->from('usuarios');
  $this->db->join('pk_usuarios', 'usuarios.ime = pk_usuarios.ime_num', 'left');
  return $this->db->get()->result_array();
}

public function contar_usuarios($filtros = []) {
  if (!empty($filtros['nome'])) {
      $this->db->like('usuarios.nome', $filtros['nome']);
  }
  if (!empty($filtros['ime'])) {
      $this->db->where('usuarios.ime', $filtros['ime']);
  }
  if (!empty($filtros['grau'])) {
      $this->db->where('pk_usuarios.ativo_no_grau', $filtros['grau']);
  }

  $this->db->join('pk_usuarios', 'usuarios.ime = pk_usuarios.ime_num', 'left');
  return $this->db->count_all_results('usuarios');
}


public function atualizar_senha($ime, $nova_senha) {

  // Atualiza a senha na tabela usuarios
  $this->db->where('ime', $ime);
  return $this->db->update('usuarios', ['senha' => md5($nova_senha)]);
}

public function atualizar_usuario($ime, $dados_usuario, $dados_pk_usuario) {
  // Atualizar tabela usuarios
  $this->db->where('ime', $ime);
  $this->db->update('usuarios', $dados_usuario);

  // Atualizar tabela pk_usuarios
  $this->db->where('ime_num', $ime);
  $this->db->update('pk_usuarios', $dados_pk_usuario);
}
public function obter_proximo_ime_num() {

  // Busca o maior valor de ime_num na tabela pk_usuarios
  $this->db->select_max('ime_num');
  $query = $this->db->get('pk_usuarios')->row_array();
  $ultimo_ime_num = $query['ime_num'];

  // Se a tabela estiver vazia, começa com 1
  $proximo_ime_num = ($ultimo_ime_num) ? $ultimo_ime_num + 1 : 1;
  

  return $proximo_ime_num;
}
public function chamado_listar_com_filtros($filtros = [], $ordenacao = []) {
  $this->db->select('*');
  $this->db->from('chamados');
  
  // Aplicar filtros
  if (!empty($filtros['usuario_ime'])) {
      $this->db->where('usuario_ime', $filtros['usuario_ime']);
  }
  
  if (!empty($filtros['status'])) {
      $this->db->where('status', $filtros['status']);
  }
  
  if (!empty($filtros['prioridade'])) {
      $this->db->where('prioridade', $filtros['prioridade']);
  }
  
  if (!empty($filtros['search'])) {
      $this->db->group_start();
      $this->db->like('titulo', $filtros['search']);
      $this->db->or_like('descricao', $filtros['search']);
      $this->db->group_end();
  }
  
  // Aplicar ordenação
  if (!empty($ordenacao)) {
      $this->db->order_by(
          "CASE WHEN status = 'aberto' THEN 0 ELSE 1 END", 
          'ASC', 
          FALSE
      );
      $this->db->order_by('data_abertura', 'DESC');
  }
  
  return $this->db->get()->result_array();
}
// Função para saber quem é adm e atendente
public function listar_administradores() {
  $this->db->where('role', 'admin');
  $this->db->or_where('role', 'atendente');
  return $this->db->get('usuarios')->result_array();
}

// Função para abrir novo chamado
public function chamado_abrir($dados) {
  return $this->db->insert('chamados', $dados);
}

// Função para listar todos os chamados
public function chamado_listar_todos() {
  $this->db->order_by('data_abertura', 'DESC');
  return $this->db->get('chamados')->result_array();
}

// Função para listar chamados por usuário
public function chamado_listar_por_usuario($ime) {
  $this->db->where('usuario_ime', $ime);
  $this->db->order_by('data_abertura', 'DESC');
  return $this->db->get('chamados')->result_array();
}

// Função para obter chamado por ID
public function chamado_obter_por_id($id) {
  return $this->db->get_where('chamados', ['id' => $id])->row_array();
}

// Função para atualizar chamado
public function chamado_atualizar($id, $dados) {
  $this->db->where('id', $id);
  return $this->db->update('chamados', $dados);
}

// Função para listar chamados por status
public function chamado_listar_por_status($status) {
  $this->db->where('status', $status);
  $this->db->order_by('data_abertura', 'DESC');
  return $this->db->get('chamados')->result_array();
}

// Função para contar chamados por status
public function chamado_contar_por_status($status = null) {
  if ($status) {
      $this->db->where('status', $status);
  }
  return $this->db->count_all_results('chamados');
}

public function verificar_ime_existe($ime) {
    $this->db->where('ime', $ime);
    return $this->db->get('usuarios')->num_rows() > 0;
}

public function obter_ultimo_ime() {
    $this->db->select('ime');
    $this->db->from('usuarios');
    $this->db->order_by('ime', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->row()->ime;
    }
    return '000.001'; // Retorna o IME inicial se não houver registros
}

}

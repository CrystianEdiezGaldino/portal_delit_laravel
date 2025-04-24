<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\CadastroRealizado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    // Definição de tabelas
    protected $tableUsuarios = 'usuarios';
    protected $tablePkUsuarios = 'pk_usuarios';
    protected $tableIeadConteudos = 'iead_conteudos';
    protected $tablePlanilhas = 'planilhas';
    protected $tableChamados = 'chamados';
    protected $primaryKey = 'ime';
    public $incrementing = false;
    protected $keyType = 'string';

    // Campos fillable para mass assignment
    protected $fillable = [
        'ime',
        'nome',
        'email',
        'senha',
        'role',
        'status',
        'grau',
        'cpf'
    ];

    // Esconde campos sensíveis
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * Validação de login
     */
    public function validateLogin($ime, $senha)
    {
        $usuario = DB::table($this->tableUsuarios)
                    ->where('ime', $ime)
                    ->first();

        if ($usuario && Hash::check($senha, $usuario->senha)) {
            return $usuario;
        }

        return null;
    }

    /**
     * Busca usuário por IME
     */
    public function buscarUsuarioPorIme($ime)
    {
        return DB::table($this->tablePkUsuarios)
                ->where('ime_num', $ime)
                ->first();
    }

    /**
     * Busca todos os dados do usuário
     */
    public function buscarTodosOsDadosUsuario($ime)
    {
        return DB::table($this->tableUsuarios)
                ->where('ime', $ime)
                ->first();
    }

    /**
     * Verifica acesso a grau
     */
    public function verificaAcessoGrau($ime, $grau)
    {
        return DB::table($this->tablePkUsuarios)
                ->where('ime_num', $ime)
                ->where('ativo_no_grau', '>=', $grau)
                ->exists();
    }

    /**
     * Verifica se usuário tem acesso ao grau
     */
    public function usuarioTemAcessoAoGrau($ime, $grau)
    {
        $maxGrau = DB::table($this->tablePkUsuarios)
                    ->where('ime_num', $ime)
                    ->max('ativo_no_grau');

        return $grau <= $maxGrau;
    }

    /**
     * Obtém dados do usuário
     */
    public function getUserData($ime)
    {
        return DB::table($this->tablePkUsuarios)
                ->where('ime_num', $ime)
                ->first();
    }

    /**
     * Conteúdos IEAD
     */
    public function inserirConteudoIead($dados)
    {
        return DB::table($this->tableIeadConteudos)->insert($dados);
    }

    public function listarConteudosIead($grau = null)
    {
        $query = DB::table($this->tableIeadConteudos);
        
        if ($grau) {
            $query->where('grau', $grau);
        }
        
        return $query->get();
    }

    public function obterConteudoIead($id)
    {
        return DB::table($this->tableIeadConteudos)
                ->where('id', $id)
                ->first();
    }

    public function atualizarConteudoIead($id, $dados)
    {
        return DB::table($this->tableIeadConteudos)
                ->where('id', $id)
                ->update($dados);
    }

    public function deletarConteudoIead($id)
    {
        return DB::table($this->tableIeadConteudos)
                ->where('id', $id)
                ->delete();
    }

    /**
     * Planilhas
     */
    public function listarPlanilhas($grau = null)
    {
        $query = DB::table($this->tablePlanilhas);
        
        if ($grau) {
            $query->where('grau_acesso', '<=', $grau);
        }
        
        return $query->get();
    }

    public function obterPlanilha($id)
    {
        return DB::table($this->tablePlanilhas)
                ->where('id', $id)
                ->first();
    }

    public function inserirPlanilha($dados)
    {
        return DB::table($this->tablePlanilhas)->insert($dados);
    }

    public function atualizarPlanilha($id, $dados)
    {
        return DB::table($this->tablePlanilhas)
                ->where('id', $id)
                ->update($dados);
    }

    public function deletarPlanilha($id)
    {
        return DB::table($this->tablePlanilhas)
                ->where('id', $id)
                ->delete();
    }

    /**
     * Usuários
     */
    public function inserirUsuario($dados)
    {
        // Hash da senha
        $dados['senha'] = Hash::make($dados['senha']);
        
        // Inserir usuário
        $usuarioId = DB::table($this->tableUsuarios)->insertGetId($dados);
        
        // Enviar e-mail (implementar Mailable)
        try {
            Mail::to($dados['email'])->send(new CadastroRealizado($dados));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar e-mail: ' . $e->getMessage());
        }
        
        return $usuarioId;
    }

    public function inserirPkUsuario($dados)
    {
        $camposPermitidos = [
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
            'grau_4_em', 'grau_5_em', 'grau_7_em', 'grau_9_em',
            'grau_10_em', 'grau_14_em', 'grau_15_em', 'grau_16_em',
            'grau_17_em', 'grau_18_em', 'grau_30_em',
            'col_corpo_4', 'col_corpo_5', 'col_corpo_7', 'col_corpo_9',
            'col_corpo_10', 'col_corpo_14', 'col_corpo_15', 'col_corpo_16',
            'col_corpo_18',
            'diploma_4_num', 'diploma_5_num', 'diploma_7_num', 'diploma_9_num',
            'diploma_10_num', 'diploma_14_num', 'diploma_15_num', 'diploma_16_num',
            'diploma_17_num', 'breve_18_num', 'patente_30_num',
            'condecoracoes_scb', 'pg_corpo_1', 'cond_rec', 'cond_gr_rec',
            'cond_mont', 'ano1', 'rec', 'gr_rec', 'monte'
        ];
        
        $dadosFiltrados = array_intersect_key($dados, array_flip($camposPermitidos));
        
        return DB::table($this->tablePkUsuarios)->insert($dadosFiltrados);
    }

    public function obterUsuarioPorId($id)
    {
        return DB::table($this->tableUsuarios)
                ->where('id', $id)
                ->first();
    }

    public function obterUsuarioPorIme($ime)
    {
        return DB::table($this->tableUsuarios)
                ->where('ime', $ime)
                ->first();
    }

    public function obterPkUsuarioPorIme($ime)
    {
        return DB::table($this->tablePkUsuarios)
                ->where('ime_num', $ime)
                ->first();
    }

    public function deletarUsuarioPorIme($ime)
    {
        return DB::table($this->tableUsuarios)
                ->where('ime', $ime)
                ->delete();
    }

    public function deletarPkUsuarioPorIme($ime)
    {
        return DB::table($this->tablePkUsuarios)
                ->where('ime_num', $ime)
                ->delete();
    }

    public function listarUsuarios($filtros = [], $limit = null, $offset = null)
    {
        $query = DB::table($this->tableUsuarios)
                ->select('usuarios.*', 'pk_usuarios.ativo_no_grau as grau')
                ->leftJoin('pk_usuarios', 'usuarios.ime', '=', 'pk_usuarios.ime_num');
        
        if (!empty($filtros['nome'])) {
            $query->where('usuarios.nome', 'like', '%'.$filtros['nome'].'%');
        }
        
        if (!empty($filtros['ime'])) {
            $query->where('usuarios.ime', $filtros['ime']);
        }
        
        if (!empty($filtros['grau'])) {
            $query->where('pk_usuarios.ativo_no_grau', $filtros['grau']);
        }
        
        if ($limit !== null) {
            $query->limit($limit)->offset($offset);
        }
        
        return $query->get();
    }

    public function contarUsuarios($filtros = [])
    {
        $query = DB::table($this->tableUsuarios)
                ->leftJoin('pk_usuarios', 'usuarios.ime', '=', 'pk_usuarios.ime_num');
        
        if (!empty($filtros['nome'])) {
            $query->where('usuarios.nome', 'like', '%'.$filtros['nome'].'%');
        }
        
        if (!empty($filtros['ime'])) {
            $query->where('usuarios.ime', $filtros['ime']);
        }
        
        if (!empty($filtros['grau'])) {
            $query->where('pk_usuarios.ativo_no_grau', $filtros['grau']);
        }
        
        return $query->count();
    }

    public function atualizarSenha($ime, $novaSenha)
    {
        return DB::table($this->tableUsuarios)
                ->where('ime', $ime)
                ->update(['senha' => Hash::make($novaSenha)]);
    }

    public function atualizarUsuario($ime, $dadosUsuario, $dadosPkUsuario)
    {
        DB::table($this->tableUsuarios)
            ->where('ime', $ime)
            ->update($dadosUsuario);
        
        DB::table($this->tablePkUsuarios)
            ->where('ime_num', $ime)
            ->update($dadosPkUsuario);
    }

    public function obterProximoImeNum()
    {
        $ultimoImeNum = DB::table($this->tablePkUsuarios)
                        ->max('ime_num');
        
        return $ultimoImeNum ? $ultimoImeNum + 1 : 1;
    }

    /**
     * Chamados
     */
    public function chamadoListarComFiltros($filtros = [], $ordenacao = [])
    {
        $query = DB::table($this->tableChamados);
        
        if (!empty($filtros['usuario_ime'])) {
            $query->where('usuario_ime', $filtros['usuario_ime']);
        }
        
        if (!empty($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }
        
        if (!empty($filtros['prioridade'])) {
            $query->where('prioridade', $filtros['prioridade']);
        }
        
        if (!empty($filtros['search'])) {
            $query->where(function($q) use ($filtros) {
                $q->where('titulo', 'like', '%'.$filtros['search'].'%')
                  ->orWhere('descricao', 'like', '%'.$filtros['search'].'%');
            });
        }
        
        if (!empty($ordenacao)) {
            $query->orderByRaw("CASE WHEN status = 'aberto' THEN 0 ELSE 1 END ASC")
                  ->orderBy('data_abertura', 'DESC');
        }
        
        return $query->get();
    }

    public function listarAdministradores()
    {
        return DB::table($this->tableUsuarios)
                ->whereIn('role', ['admin', 'atendente'])
                ->get();
    }

    public function chamadoAbrir($dados)
    {
        return DB::table($this->tableChamados)->insert($dados);
    }

    public function chamadoListarTodos()
    {
        return DB::table($this->tableChamados)
                ->orderBy('data_abertura', 'DESC')
                ->get();
    }

    public function chamadoListarPorUsuario($ime)
    {
        return DB::table($this->tableChamados)
                ->where('usuario_ime', $ime)
                ->orderBy('data_abertura', 'DESC')
                ->get();
    }

    public function chamadoObterPorId($id)
    {
        return DB::table($this->tableChamados)
                ->where('id', $id)
                ->first();
    }

    public function chamadoAtualizar($id, $dados)
    {
        return DB::table($this->tableChamados)
                ->where('id', $id)
                ->update($dados);
    }

    public function chamadoListarPorStatus($status)
    {
        return DB::table($this->tableChamados)
                ->where('status', $status)
                ->orderBy('data_abertura', 'DESC')
                ->get();
    }

    public function chamadoContarPorStatus($status = null)
    {
        $query = DB::table($this->tableChamados);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->count();
    }

    public function verificarImeExiste($ime)
    {
        return DB::table($this->tableUsuarios)
                ->where('ime', $ime)
                ->exists();
    }

    public function obterUltimoIme()
    {
        $ultimoIme = DB::table($this->tableUsuarios)
                    ->orderBy('ime', 'DESC')
                    ->value('ime');
        
        return $ultimoIme ?: '000.001';
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
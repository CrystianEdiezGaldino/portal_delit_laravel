<?php

namespace App\Services;

use App\Models\Usuario;
use App\Models\PkUsuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    protected $usuario;
    protected $pkUsuario;
    protected $emailService;

    public function __construct(Usuario $usuario, PkUsuario $pkUsuario, EmailService $emailService)
    {
        $this->usuario = $usuario;
        $this->pkUsuario = $pkUsuario;
        $this->emailService = $emailService;
    }

    public function autenticar($ime, $senha)
    {
        $usuario = $this->usuario->where('ime', $ime)->first();

        if ($usuario && md5($senha) === $usuario->senha) {
            return $usuario;
        }

        return null;
    }

    public function criarUsuario($dados)
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuario->create([
                'ime' => $dados['ime'],
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'senha' => md5($dados['senha']),
                'role' => $dados['role'] ?? 'usuario',
                'status' => 'ativo'
            ]);

            // Envia email com as credenciais
            $dadosEmail = [
                'nome' => $usuario->nome,
                'ime' => $usuario->ime,
                'email' => $usuario->email,
                'senha' => $dados['senha']
            ];

            $this->emailService->enviarEmailCadastro($dadosEmail);

            DB::commit();
            return $usuario;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function criarPkUsuario($ime, $dados)
    {
        try {
            DB::beginTransaction();

            $pkUsuario = $this->pkUsuario->create([
                'ime_num' => $ime,
                'cadastro' => $dados['nome'],
                'cic' => preg_replace('/[^0-9]/', '', $dados['cic']),
                'email' => $dados['email'],
                'pai' => $dados['pai'],
                'mae' => $dados['mae'],
                'nascimento' => $dados['nascimento'],
                'cidade1' => $dados['cidade1'],
                'estado1' => $dados['estado1'],
                'nacionalidade' => $dados['nacionalidade'],
                'profissao' => $dados['profissao'],
                'endereco_residencial' => $dados['endereco_residencial'],
                'bairro' => $dados['bairro'],
                'cidade' => $dados['cidade'],
                'estado' => $dados['estado'],
                'cep' => $dados['cep'],
                'telefone_residencial' => $dados['telefone_residencial'],
                'telefone_comercial' => $dados['telefone_comercial'],
                'celular' => $dados['celular'],
                'estado_civil' => $dados['estado_civil'],
                'numero_filhos' => $dados['numero_filhos'],
                'sexo_m' => $dados['sexo_m'] ?? 0,
                'sexo_f' => $dados['sexo_f'] ?? 0,
                'esposa' => $dados['esposa'],
                'nascida' => $dados['nascida'],
                'casamento' => $dados['casamento'],
                'ativo_no_grau' => $dados['ativo_no_grau'] ?? 1
            ]);

            // Atualiza dados do usuário
            $this->usuario->where('ime', $ime)->update([
                'grau' => $dados['ativo_no_grau'] ?? 1,
                'email' => $dados['email'],
                'cpf' => preg_replace('/[^0-9]/', '', $dados['cic'])
            ]);

            DB::commit();
            return $pkUsuario;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarUsuario($id, $dados)
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuario->findOrFail($id);
            
            $dadosUsuario = [
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'role' => $dados['role'] ?? $usuario->role,
                'grau' => $dados['grau'] ?? $usuario->grau
            ];

            if (!empty($dados['senha'])) {
                $dadosUsuario['senha'] = md5($dados['senha']);
            }

            $usuario->update($dadosUsuario);

            // Atualiza dados do pk_usuario
            $this->pkUsuario->where('ime_num', $usuario->ime)->update([
                'cadastro' => $dados['nome'],
                'email' => $dados['email'],
                'pai' => $dados['pai'],
                'mae' => $dados['mae'],
                'nascimento' => $dados['nascimento'],
                'cidade1' => $dados['cidade1'],
                'estado1' => $dados['estado1'],
                'nacionalidade' => $dados['nacionalidade'],
                'profissao' => $dados['profissao'],
                'endereco_residencial' => $dados['endereco_residencial'],
                'bairro' => $dados['bairro'],
                'cidade' => $dados['cidade'],
                'estado' => $dados['estado'],
                'cep' => $dados['cep'],
                'telefone_residencial' => $dados['telefone_residencial'],
                'telefone_comercial' => $dados['telefone_comercial'],
                'celular' => $dados['celular'],
                'estado_civil' => $dados['estado_civil'],
                'numero_filhos' => $dados['numero_filhos'],
                'sexo_m' => $dados['sexo_m'] ?? 0,
                'sexo_f' => $dados['sexo_f'] ?? 0,
                'esposa' => $dados['esposa'],
                'nascida' => $dados['nascida'],
                'casamento' => $dados['casamento'],
                'ativo_no_grau' => $dados['grau'] ?? 1
            ]);

            DB::commit();
            return $usuario;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletarUsuario($ime)
    {
        try {
            DB::beginTransaction();

            $this->usuario->where('ime', $ime)->delete();
            $this->pkUsuario->where('ime_num', $ime)->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function buscarUsuario($ime)
    {
        return $this->usuario->where('ime', $ime)->first();
    }

    public function buscarDadosUsuario($ime)
    {
        $usuario = $this->usuario->where('ime', $ime)->first();
        $pkUsuario = $this->pkUsuario->where('ime_num', $ime)->first();

        return [
            'usuario' => $usuario,
            'pk_usuario' => $pkUsuario
        ];
    }

    public function buscarDadosForm20($ime)
    {
        return $this->pkUsuario->where('ime_num', $ime)->first();
    }

    public function buscarUltimoIme()
    {
        return $this->usuario->max('ime');
    }

    public function listarUsuarios($filtros = [])
    {
        $query = $this->usuario->query();

        if (!empty($filtros['nome'])) {
            $query->where('nome', 'like', "%{$filtros['nome']}%");
        }

        if (!empty($filtros['ime'])) {
            $query->where('ime', 'like', "%{$filtros['ime']}%");
        }

        if (!empty($filtros['grau'])) {
            $query->where('grau', $filtros['grau']);
        }

        return $query->paginate(100);
    }
} 
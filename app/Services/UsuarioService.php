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
    protected $usuarioRepository;
    protected $pkUsuarioRepository;

    public function __construct(
        Usuario $usuario, 
        PkUsuario $pkUsuario, 
        EmailService $emailService,
        \App\Repositories\UsuarioRepository $usuarioRepository,
        \App\Repositories\PkUsuarioRepository $pkUsuarioRepository
    ) {
        $this->usuario = $usuario;
        $this->pkUsuario = $pkUsuario;
        $this->emailService = $emailService;
        $this->usuarioRepository = $usuarioRepository;
        $this->pkUsuarioRepository = $pkUsuarioRepository;
    }

    public function autenticar($ime, $senha)
    {
        $usuario = $this->usuario->where('ime', $ime)->first();

        if ($usuario && md5($senha) === $usuario->senha) {
            return $usuario;
        }

        return null;
    }

    public function criarUsuario(array $dados)
    {
        return $this->usuarioRepository->criar($dados);
    }

    public function criarPkUsuario($dados)
    {
        try {
            DB::beginTransaction();

            $pkUsuario = $this->pkUsuarioRepository->criar([
                'ime_num' => $dados['ime_num'],
                'cadastro' => $dados['cadastro'],
                'email' => $dados['email'],
                'cic' => $dados['cic'],
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
                'casamento' => $dados['casamento'],
                'esposa' => $dados['esposa'],
                'nascida' => $dados['nascida'],
                'rg' => $dados['rg'],
                'orgao_expedidor' => $dados['orgao_expedidor'],
                'iniciado_loja' => $dados['iniciado_loja'],
                'numero_loja' => $dados['numero_loja'],
                'potencia_inicial' => $dados['potencia_inicial'],
                'cidade2' => $dados['cidade2'],
                'estado2' => $dados['estado2'],
                'membro_ativo_loja' => $dados['membro_ativo_loja'],
                'numero_da_loja' => $dados['numero_da_loja'],
                'cidade3' => $dados['cidade3'],
                'estado3' => $dados['estado3'],
                'apr_em' => $dados['apr_em'],
                'comp_em' => $dados['comp_em'],
                'mest_em' => $dados['mest_em'],
                'mi_em' => $dados['mi_em'],
                'potencia_corpo_filosofico' => $dados['potencia_corpo_filosofico'],
                'ativo_no_grau' => $dados['ativo_no_grau'],
                'codigo' => $dados['codigo'],
                'tipo_categoria' => $dados['tipo_categoria'],
                'cond_rec' => $dados['cond_rec'],
                'cond_gr_rec' => $dados['cond_gr_rec'],
                'cond_mont' => $dados['cond_mont'],
                'rec' => $dados['rec'],
                'gr_rec' => $dados['gr_rec'],
                'monte' => $dados['monte'],
                'condecoracoes_scb' => $dados['condecoracoes_scb'],
                'grau_4_em' => $dados['grau_4_em'] ?? null,
                'col_corpo_1' => $dados['col_corpo_1'] ?? null,
                'diploma_4_num' => $dados['diploma_4_num'] ?? null,
                'grau_5_em' => $dados['grau_5_em'] ?? null,
                'col_corpo_05' => $dados['col_corpo_05'] ?? null,
                'diploma_5_num' => $dados['diploma_5_num'] ?? null,
                'grau_7_em' => $dados['grau_7_em'] ?? null,
                'col_corpo_14' => $dados['col_corpo_14'] ?? null,
                'diploma_7_num' => $dados['diploma_7_num'] ?? null,
                'grau_9_em' => $dados['grau_9_em'] ?? null,
                'col_corpo_2' => $dados['col_corpo_2'] ?? null,
                'diploma_9_num' => $dados['diploma_9_num'] ?? null,
                'grau_10_em' => $dados['grau_10_em'] ?? null,
                'col_corpo_3' => $dados['col_corpo_3'] ?? null,
                'diploma_10_num' => $dados['diploma_10_num'] ?? null,
                'grau_14_em' => $dados['grau_14_em'] ?? null,
                'col_corpo_4' => $dados['col_corpo_4'] ?? null,
                'diploma_14_num' => $dados['diploma_14_num'] ?? null,
                'grau_15_em' => $dados['grau_15_em'] ?? null,
                'col_corpo_5' => $dados['col_corpo_5'] ?? null,
                'diploma_15_num' => $dados['diploma_15_num'] ?? null,
                'grau_16_em' => $dados['grau_16_em'] ?? null,
                'col_corpo_15' => $dados['col_corpo_15'] ?? null,
                'diploma_16_num' => $dados['diploma_16_num'] ?? null,
                'grau_17_em' => $dados['grau_17_em'] ?? null,
                'col_corpo_16' => $dados['col_corpo_16'] ?? null,
                'diploma_17_num' => $dados['diploma_17_num'] ?? null,
                'grau_18_em' => $dados['grau_18_em'] ?? null,
                'col_corpo_6' => $dados['col_corpo_6'] ?? null,
                'breve_18_num' => $dados['breve_18_num'] ?? null,
                'grau_19_em' => $dados['grau_19_em'] ?? null,
                'col_corpo_7' => $dados['col_corpo_7'] ?? null,
                'diploma_19_num' => $dados['diploma_19_num'] ?? null,
                'grau_22_em' => $dados['grau_22_em'] ?? null,
                'col_corpo_8' => $dados['col_corpo_8'] ?? null,
                'diploma_22_num' => $dados['diploma_22_num'] ?? null,
                'grau_29_em' => $dados['grau_29_em'] ?? null,
                'col_corpo_9' => $dados['col_corpo_9'] ?? null,
                'diploma_29_num' => $dados['diploma_29_num'] ?? null,
                'grau_30_em' => $dados['grau_30_em'] ?? null,
                'col_corpo_10' => $dados['col_corpo_10'] ?? null,
                'patente_30_num' => $dados['patente_30_num'] ?? null,
                'grau_31_em' => $dados['grau_31_em'] ?? null,
                'col_corpo_11' => $dados['col_corpo_11'] ?? null,
                'patente_31_num' => $dados['patente_31_num'] ?? null,
                'grau_32_em' => $dados['grau_32_em'] ?? null,
                'col_corpo_12' => $dados['col_corpo_12'] ?? null,
                'patente_32_num' => $dados['patente_32_num'] ?? null,
                'grau_33_em' => $dados['grau_33_em'] ?? null,
                'col_corpo_13' => $dados['col_corpo_13'] ?? null,
                'patente_33_num' => $dados['patente_33_num'] ?? null
            ]);

            DB::commit();
            return $pkUsuario;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarUsuario($ime, $dados)
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuarioRepository->buscarPorIme($ime);
            
            if (!$usuario) {
                throw new \Exception('Usuário não encontrado');
            }

            $dadosUsuario = [
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'role' => $dados['role'] ?? $usuario->role,
                'grau' => $dados['grau'] ?? $usuario->grau,
                'cpf' => $dados['cpf'] ?? $usuario->cpf
            ];

            // Só atualiza a senha se for fornecida
            if (!empty($dados['senha'])) {
                $dadosUsuario['senha'] = Hash::make($dados['senha']);
            }

            $this->usuarioRepository->atualizar($usuario->id, $dadosUsuario);

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

            $usuario = $this->usuarioRepository->buscarPorIme($ime);
            if ($usuario) {
                $this->usuarioRepository->deletar($usuario->id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function buscarUsuario($ime)
    {
        return $this->usuarioRepository->buscarPorIme($ime);
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
        return $this->usuarioRepository->listarUsuarios($filtros);
    }

    /**
     * Busca um usuário na tabela pk_usuarios pelo IME
     */
    public function buscarPorIme($ime)
    {
        return $this->usuarioRepository->buscarPorIme($ime);
    }
} 
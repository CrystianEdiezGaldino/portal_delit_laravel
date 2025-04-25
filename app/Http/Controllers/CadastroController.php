<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsuarioService;
use App\Mail\PrimeiroAcesso;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\PkUsuario;
use Illuminate\Support\Facades\DB;
use App\Mail\CadastroAtualizado;

class CadastroController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function etapa1()
    {
        return view('cadastro.etapa1');
    }

    public function etapa1Process(Request $request)
    {
        $request->validate([
            'ime' => 'required|string|max:7|regex:/^\d{3}\.\d{3}$/|unique:usuarios,ime',
            'cpf' => 'required|string|max:14|unique:pk_usuarios,cic',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'role' => 'required|string|in:usuario,admin,atendente',
            'grau' => 'required|string|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33'
        ]);

        try {
            DB::beginTransaction();

            // Gera senha automática
            $senha = $this->gerarSenhaAleatoria();

            // Cria o usuário
            $usuario = $this->usuarioService->criarUsuario([
                'ime' => $request->ime,
                'nome' => $request->nome,
                'email' => $request->email,
                'senha' => hash('sha256', $senha),
                'role' => $request->role,
                'cpf' => $request->cpf,
                'grau' => $request->grau
            ]);

            // Armazena os dados da etapa 1 na sessão
            $request->session()->put('cadastro.etapa1', $request->all());

            DB::commit();

            // Redireciona para a etapa 2
            return redirect()->route('cadastro.etapa2', ['ime' => $request->ime]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao cadastrar usuário. Por favor, tente novamente.']);
        }
    }

    public function etapa2(Request $request, $ime)
    {
        if (!session()->has('cadastro.etapa1')) {
            return redirect()->route('cadastro.etapa1');
        }

        $dadosEtapa1 = session('cadastro.etapa1');
        
        return view('cadastro.etapa2', [
            'ime' => $ime,
            'dadosEtapa1' => $dadosEtapa1
        ]);
    }

    public function etapa2Process(Request $request)
    {
        try {
            $dadosEtapa1 = $request->session()->get('cadastro.etapa1');
            
            if (!$dadosEtapa1) {
                return redirect()->route('cadastro.etapa1')->with('error', 'Dados da etapa 1 não encontrados');
            }

            $validated = $request->validate([
                'cadastro' => 'required|string|max:255',
                'cic' => 'required|string|max:14',
                'pai' => 'nullable|string|max:255',
                'mae' => 'nullable|string|max:255',
                'nascimento' => 'nullable|date',
                'cidade1' => 'nullable|string|max:255',
                'estado1' => 'nullable|string|max:2',
                'nacionalidade' => 'nullable|string|max:255',
                'profissao' => 'nullable|string|max:255',
                'endereco_residencial' => 'nullable|string|max:255',
                'bairro' => 'nullable|string|max:255',
                'cidade' => 'nullable|string|max:255',
                'estado' => 'nullable|string|max:2',
                'cep' => 'nullable|string|max:9',
                'telefone_residencial' => 'nullable|string|max:20',
                'telefone_comercial' => 'nullable|string|max:20',
                'celular' => 'nullable|string|max:20',
                'estado_civil' => 'nullable|string|max:50',
                'numero_filhos' => 'nullable|string|max:10',
                'casamento' => 'nullable|date',
                'esposa' => 'nullable|string|max:255',
                'nascida' => 'nullable|date',
                'rg' => 'nullable|string|max:20',
                'orgao_expedidor' => 'nullable|string|max:50',
                'iniciado_loja' => 'nullable|string|max:50',
                'numero_loja' => 'nullable|string|max:50',
                'potencia_inicial' => 'nullable|string|max:255',
                'cidade2' => 'nullable|string|max:255',
                'estado2' => 'nullable|string|max:2',
                'membro_ativo_loja' => 'nullable|string|max:1',
                'numero_da_loja' => 'nullable|string|max:50',
                'cidade3' => 'nullable|string|max:255',
                'estado3' => 'nullable|string|max:2',
                'apr_em' => 'nullable|date',
                'comp_em' => 'nullable|date',
                'mest_em' => 'nullable|date',
                'mi_em' => 'nullable|date',
                'potencia_corpo_filosofico' => 'nullable|string|max:255',
                'ativo_no_grau' => 'required|integer|min:1|max:33',
                'codigo' => 'nullable|string|max:50',
                'tipo_categoria' => 'nullable|string|max:50',
                'cond_rec' => 'nullable|string|max:50',
                'cond_gr_rec' => 'nullable|string|max:50',
                'cond_mont' => 'nullable|string|max:50',
                'rec' => 'nullable|string|max:50',
                'gr_rec' => 'nullable|string|max:50',
                'monte' => 'nullable|string|max:50',
                'condecoracoes_scb' => 'nullable|string'
            ]);

            // Adicionar campos dos graus adicionais
            $graus = [
                4 => ['col_corpo_1', 'diploma_4_num'],
                5 => ['col_corpo_05', 'diploma_5_num'],
                7 => ['col_corpo_14', 'diploma_7_num'],
                9 => ['col_corpo_2', 'diploma_9_num'],
                10 => ['col_corpo_3', 'diploma_10_num'],
                14 => ['col_corpo_4', 'diploma_14_num'],
                15 => ['col_corpo_5', 'diploma_15_num'],
                16 => ['col_corpo_15', 'diploma_16_num'],
                17 => ['col_corpo_16', 'diploma_17_num'],
                18 => ['col_corpo_6', 'breve_18_num'],
                19 => ['col_corpo_7', 'diploma_19_num'],
                22 => ['col_corpo_8', 'diploma_22_num'],
                29 => ['col_corpo_9', 'diploma_29_num'],
                30 => ['col_corpo_10', 'patente_30_num'],
                31 => ['col_corpo_11', 'patente_31_num'],
                32 => ['col_corpo_12', 'patente_32_num'],
                33 => ['col_corpo_13', 'patente_33_num']
            ];

            foreach ($graus as $grau => $campos) {
                $validated['grau_' . $grau . '_em'] = $request->input('grau_' . $grau . '_em');
                $validated[$campos[0]] = $request->input($campos[0]);
                $validated[$campos[1]] = $request->input($campos[1]);
            }

            // Buscar usuário existente
            $usuario = $this->usuarioService->buscarUsuario($dadosEtapa1['ime']);
            
            if (!$usuario) {
                return redirect()->route('cadastro.etapa1')->with('error', 'Usuário não encontrado');
            }

            // Buscar email do usuário na tabela usuarios
            $emailUsuario = Usuario::where('ime', $dadosEtapa1['ime'])->value('email');
          

            // Criar registro na tabela pk_usuarios
            $pkUsuario = $this->usuarioService->criarPkUsuario(array_merge(
                $validated,
                [
                    'ime_num' => $usuario->ime,
                    'cadastro' => $usuario->nome,
                    'email' => $emailUsuario,
                    'cic' => $dadosEtapa1['cpf']
                ]
            ));

            // Enviar email de cadastro atualizado
            try {
                \Illuminate\Support\Facades\Log::info('Iniciando envio de email para: ' . $emailUsuario);
                
                // Verificar se o email é válido
                if (!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)) {
                    \Illuminate\Support\Facades\Log::error('Email inválido: ' . $emailUsuario);
                    throw new \Exception('Email inválido');
                }

                // Verificar configurações de email
                \Illuminate\Support\Facades\Log::info('Configurações de email: ' . json_encode([
                    'host' => config('mail.host'),
                    'port' => config('mail.port'),
                    'username' => config('mail.username'),
                    'encryption' => config('mail.encryption')
                ]));

                // Tentar enviar o email
                $mail = new CadastroAtualizado($usuario->nome, $usuario->ime);
                Mail::to($emailUsuario)->send($mail);
                
                \Illuminate\Support\Facades\Log::info('Email enviado com sucesso para: ' . $emailUsuario);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erro ao enviar email: ' . $e->getMessage());
                \Illuminate\Support\Facades\Log::error('Stack trace: ' . $e->getTraceAsString());
                return back()->with('error', 'Cadastro realizado, mas houve um problema ao enviar o email. Por favor, tente reenviar o email.');
            }

            // Limpar dados da sessão
            $request->session()->forget('cadastro.etapa1');

            // Redirecionar para a página de sucesso
            return redirect()->route('cadastro.sucesso', $usuario->ime)->with('success', 'Cadastro realizado com sucesso!');

        } catch (\Exception $e) {
            // Em caso de erro, mantém os dados no formulário
            $request->session()->put('cadastro.etapa1', $dadosEtapa1);
            return back()->withInput()->with('error', 'Erro ao processar cadastro: ' . $e->getMessage());
        }
    }

    /**
     * Mostra a view de sucesso após o cadastro
     */
    public function sucesso($ime)
    {
        $usuario = $this->usuarioService->buscarUsuario($ime);
        
        if (!$usuario) {
            return redirect()->route('cadastro.etapa1')->with('error', 'Usuário não encontrado.');
        }

        return view('cadastro.sucesso', compact('usuario'));
    }

    /**
     * Envia a senha por email
     */
    public function enviarSenha($ime)
    {
        try {
            $usuario = $this->usuarioService->buscarUsuario($ime);
            
            if (!$usuario) {
                return back()->with('error', 'Usuário não encontrado.');
            }

            $senha = $this->gerarSenhaAleatoria();
            
            // Atualiza a senha no banco
            $this->usuarioService->atualizarUsuario($ime, ['senha' => $senha]);
            
            // Envia o email
            Mail::to($usuario->email)
                ->send(new PrimeiroAcesso($ime, $senha, $usuario->nome));
            
            return back()->with('success', 'Senha enviada com sucesso para o email cadastrado!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao enviar senha. Por favor, tente novamente.');
        }
    }

    /**
     * Gera senha aleatória
     */
    private function gerarSenhaAleatoria()
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $senha = '';
        
        for ($i = 0; $i < 6; $i++) {
            $senha .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        
        return $senha;
    }

    /**
     * Listar usuários com paginação
     */
    public function listarUsuarios(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(404);
        }

        $filtros = [
            'nome' => $request->input('nome', ''),
            'ime' => $request->input('ime', ''),
            'grau' => $request->input('grau', '')
        ];
        
        $usuarios = $this->usuarioService->listarUsuarios($filtros);
        
        return view('cadastro.listar_usuarios', [
            'usuarios' => $usuarios,
            'total_usuarios' => $usuarios->total(),
            'filtros' => $filtros
        ]);
    }

    /**
     * Editar usuário
     */
    public function editarUsuario($ime)
    {
        if (auth()->user()->role !== 'admin') {
            abort(404);
        }

        $dados = $this->usuarioService->buscarDadosUsuario($ime);
        
        return view('cadastro.editar_usuario', [
            'usuario' => $dados['usuario'],
            'pk_usuario' => $dados['pk_usuario']
        ]);
    }

    /**
     * Salvar edição de usuário
     */
    public function salvarEdicaoUsuario($ime, Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(404);
        }

        try {
            $this->usuarioService->atualizarUsuario($ime, $request->all());
            return redirect()->route('listar.usuarios')->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao atualizar usuário. Por favor, tente novamente.']);
        }
    }

    /**
     * Deletar usuário
     */
    public function deletarUsuario($ime)
    {
        if (auth()->user()->role !== 'admin') {
            abort(404);
        }

        try {
            $this->usuarioService->deletarUsuario($ime);
            return redirect()->route('listar.usuarios')->with('success', 'Usuário deletado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao deletar usuário. Por favor, tente novamente.']);
        }
    }

    /**
     * Primeiro acesso do usuário
     */
    public function primeiroAcesso(Request $request)
    {
        try {
            $request->validate([
                'ime' => 'required',
                'cpf' => 'required'
            ]);
        
            $ime = $request->input('ime');
            $cpf = preg_replace('/[^0-9]/', '', $request->input('cpf'));
        
            $pkUsuario = $this->usuarioService->buscarPorIme($ime);
        
            if (!$pkUsuario) {
                return back()->withInput()->with('error', 'IME não encontrado. Verifique as informações ou entre em contato com o administrador.');
            }
            
            $cicLimpo = preg_replace('/[^0-9]/', '', $pkUsuario->cic);
         
            if ($cicLimpo !== $cpf) {
                return back()->withInput()->with('error', 'CPF não confere com o IME informado. Verifique as informações.');
            }
            
            $usuario = $this->usuarioService->buscarUsuario($ime);
      
            if (!$usuario) {
                return back()->withInput()->with('error', 'Usuário não encontrado. Entre em contato com o administrador.');
            }
            
            if (empty($usuario->email)) {
                return back()->withInput()->with('error', 'E-mail não cadastrado. Entre em contato com o administrador.');
            }
            
            $senha = $this->gerarSenhaAleatoria();
            
            try {
                $this->usuarioService->atualizarUsuario($ime, ['senha' => $senha]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erro ao atualizar senha: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Erro ao atualizar senha. Por favor, tente novamente.');
            }
            
            try {
                Mail::to($usuario->email)
                    ->send(new PrimeiroAcesso($ime, $senha, $pkUsuario->cadastro));
                
                return back()->with('success', 'Senha atualizada com sucesso! Verifique seu e-mail para obter a nova senha.');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erro ao enviar email: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Senha atualizada, mas houve um problema ao enviar o e-mail. Entre em contato com o administrador.');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro no primeiro acesso: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente ou entre em contato com o administrador.');
        }
    }
} 
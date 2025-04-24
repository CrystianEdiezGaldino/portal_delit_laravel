<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PrimeiroAcesso;
use TCPDF;
use App\Models\Cadastro;
use App\Models\Email;
use App\Models\Usuario;
use App\Models\PkUsuario;
use App\Models\ConteudoIead;
use App\Models\Planilha;
use App\Models\Chamado;
use App\Services\UsuarioService;
use App\Services\EmailService;
use App\Services\ChamadoService;
use App\Services\ConteudoIeadService;
use App\Services\PlanilhaService;
use App\Services\PdfService;
use App\Services\VideoService;
use App\Services\ContatoService;
use App\Services\PrimeiroAcessoService;
use App\Services\FinanceiroService;
use Illuminate\Support\Facades\DB;

class Controlador extends Controller
{
    protected $usuarioService;
    protected $emailService;
    protected $chamadoService;
    protected $conteudoIeadService;
    protected $planilhaService;
    protected $pdfService;
    protected $videoService;
    protected $contatoService;
    protected $primeiroAcessoService;
    protected $financeiroService;

    // Extensão customizada do TCPDF
    private $MYPDF;

    public function __construct(
        UsuarioService $usuarioService,
        EmailService $emailService,
        ChamadoService $chamadoService,
        ConteudoIeadService $conteudoIeadService,
        PlanilhaService $planilhaService,
        PdfService $pdfService,
        VideoService $videoService,
        ContatoService $contatoService,
        PrimeiroAcessoService $primeiroAcessoService,
        FinanceiroService $financeiroService
    ) {
        $this->usuarioService = $usuarioService;
        $this->emailService = $emailService;
        $this->chamadoService = $chamadoService;
        $this->conteudoIeadService = $conteudoIeadService;
        $this->planilhaService = $planilhaService;
        $this->pdfService = $pdfService;
        $this->videoService = $videoService;
        $this->contatoService = $contatoService;
        $this->primeiroAcessoService = $primeiroAcessoService;
        $this->financeiroService = $financeiroService;

        $this->MYPDF = new class extends TCPDF {
            public function Header() {}
            public function Footer() {}
        };
    }

    /**
     * Verifica se o usuário está logado
     */
    private function checkLogin()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    /**
     * Carrega uma página com o template padrão
     */
    private function loadPage($page, $viewData = [])
    {
        if ($page !== 'login') {
            $this->checkLogin();
        }

        $data = [
            'current_page' => $page,
            'user_data' => Auth::user()
        ];

        if (!empty($viewData)) {
            $data = array_merge($data, $viewData);
        }

        return view($page, $data);
    }

    /**
     * Página inicial do sistema
     */
    public function index()
    {
        $this->checkLogin();
        return $this->loadPage('dashboard');
    }

    /**
     * Processa o login do usuário
     */
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        if ($request->isMethod('post')) {
            $credentials = [
                'ime' => trim($request->input('ime')),
                'password' => trim($request->input('senha'))
            ];

            // Log para debug
            \Illuminate\Support\Facades\Log::info('Tentativa de login', [
                'ime' => $credentials['ime'],
                'senha_fornecida' => $credentials['password'],
                'senha_hash' => hash('sha256', $credentials['password'])
            ]);

            $user = Usuario::where('ime', $credentials['ime'])->first();
          
            if (!$user) {
                \Illuminate\Support\Facades\Log::error('Usuário não encontrado', ['ime' => $credentials['ime']]);
                return redirect()->route('login')->with('error', 'Usuário não encontrado');
            }

            // Log para debug
            \Illuminate\Support\Facades\Log::info('Usuário encontrado', [
                'ime' => $user->ime,
                'senha_banco' => $user->senha
            ]);

            $senhaHash = hash('sha256', $credentials['password']);
            
            if ($senhaHash === $user->senha) {
                // Carrega os dados adicionais do usuário
                $pkUsuario = PkUsuario::where('ime_num', $user->ime)->first();
               
                if ($pkUsuario) {
                    // Armazena dados importantes na sessão
                    session([
                        'user_grau' => $pkUsuario->ativo_no_grau,
                        'user_nome' => $user->nome,
                        'user_email' => $user->email
                    ]);
                    
                    Auth::login($user);
                    return redirect()->route('dashboard');
                }
            }

            \Illuminate\Support\Facades\Log::error('Senha incorreta', [
                'senha_fornecida_hash' => $senhaHash,
                'senha_banco' => $user->senha
            ]);

            return redirect()->route('login')->with('error', 'Senha incorreta');
        }

        return view('auth.login');
    }

    /**
     * Página do dashboard
     */
    public function dashboard()
    {
        $this->checkLogin();
        return $this->loadPage('dashboard');
    }

    /**
     * Realiza o logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Páginas do Menu Principal
    public function tutoriais()
    {
        $this->checkLogin();
        return $this->loadPage('tutoriais');
    }

    public function carteira()
    {
        $this->checkLogin();
        return $this->loadPage('carteira');
    }

    public function calendario()
    {
        $this->checkLogin();
        return $this->loadPage('calendario');
    }

    public function boletins()
    {
        $this->checkLogin();
        return $this->loadPage('boletins');
    }

    public function publicacoes()
    {
        $this->checkLogin();
        return $this->loadPage('publicacoes');
    }

    // Submenu Membros
    public function perfilMembro()
    {
        $this->checkLogin();
        return $this->loadPage('perfil_membro');
    }

    public function historicoParticipacao()
    {
        $this->checkLogin();
        return $this->loadPage('historico_participacao');
    }

    // Outras Páginas
    public function delegacias()
    {
        $this->checkLogin();
        return $this->loadPage('delegacias');
    }

    public function contato()
    {
        $this->checkLogin();
        return $this->loadPage('contato');
    }

    // Menu Especial
    public function clube()
    {
        $this->checkLogin();
        return $this->loadPage('clube');
    }

    public function anuidades()
    {
        $this->checkLogin();
        return $this->loadPage('anuidades');
    }

    public function elevacoes()
    {
        $this->checkLogin();
        return $this->loadPage('elevacoes');
    }

    public function diploma()
    {
        $this->checkLogin();
        return $this->loadPage('diploma');
    }

    /**
     * Envia mensagem de contato
     */
    public function enviarMensagem(Request $request)
    {
        $this->checkLogin();
        
        $nome = $request->input('nome');
        $email = $request->input('email');
        $assunto = $request->input('assunto');
        $mensagem = $request->input('mensagem');
        
        $corpo = "
            <h2>Nova mensagem de contato</h2>
            <p><strong>Nome:</strong> {$nome}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Assunto:</strong> {$assunto}</p>
            <hr>
            <h3>Mensagem:</h3>
            <p>{$mensagem}</p>
        ";
        
        try {
            Mail::send([], [], function($message) use ($assunto, $corpo) {
                $message->to('no-reply@delitcuritiba.org')
                        ->subject('Contato via Portal: ' . $assunto)
                        ->html($corpo);
            });
            
            return redirect()->route('contato')->with('success', 'Mensagem enviada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('contato')->with('error', 'Erro ao enviar mensagem. Tente novamente.');
        }
    }

    /**
     * Limpa dados flash da sessão
     */
    public function clearFlashData()
    {
session()->forget(['error', 'success']);
        return response()->json(['status' => 'success']);
    }

    /**
     * Lista chamados com filtros
     */
    public function chamadoIndex(Request $request)
    {
        $this->checkLogin();
        
        $userRole = Auth::user()->role;
        $userIme = Auth::user()->ime;
        
        $filtros = [
            'status' => $request->query('status'),
            'prioridade' => $request->query('prioridade'),
            'search' => $request->query('search')
        ];
        
        if (!in_array($userRole, ['admin', 'atendente'])) {
            $filtros['usuario_ime'] = $userIme;
        }
        
        $ordenacao = [
            'campo' => 'status',
            'direcao' => 'ASC',
            'segundo_campo' => 'data_abertura',
            'segunda_direcao' => 'DESC'
        ];
        
        $chamados = Chamado::query()
            ->when($filtros['status'], function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($filtros['prioridade'], function($query, $prioridade) {
                return $query->where('prioridade', $prioridade);
            })
            ->when($filtros['search'], function($query, $search) {
                return $query->where('titulo', 'like', "%{$search}%")
                            ->orWhere('descricao', 'like', "%{$search}%");
            })
            ->when(isset($filtros['usuario_ime']), function($query) use ($filtros) {
                return $query->where('usuario_ime', $filtros['usuario_ime']);
            })
            ->orderBy($ordenacao['campo'], $ordenacao['direcao'])
            ->orderBy($ordenacao['segundo_campo'], $ordenacao['segunda_direcao'])
            ->paginate(15);
        
        return $this->loadPage('chamado.index', [
            'chamados' => $chamados,
            'user_role' => $userRole
        ]);
    }

    /**
     * Exibe formulário para novo chamado
     */
    public function chamadoNovo()
    {
        $this->checkLogin();
        return $this->loadPage('chamado.novo');
    }

    /**
     * Abre um novo chamado
     */
    public function chamadoAbrir(Request $request)
    {
        $this->checkLogin();
        
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descricao' => 'required',
            'prioridade' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('chamado.novo')
                            ->withErrors($validator)
                            ->withInput();
        }
        
        $dados = [
            'usuario_ime' => Auth::user()->ime,
            'titulo' => $request->input('titulo'),
            'descricao' => $request->input('descricao'),
            'prioridade' => $request->input('prioridade'),
            'status' => 'aberto',
            'data_abertura' => now()
        ];
        
        Chamado::create($dados);
        
        return redirect()->route('chamado.index')->with('success', 'Chamado aberto com sucesso!');
    }

    /**
     * Atende um chamado
     */
    public function chamadoAtender($id)
    {
        $this->checkLogin();
        
        try {
            $userRole = Auth::user()->role;
            
            if (!in_array($userRole, ['admin', 'atendente'])) {
                throw new \Exception('Você não tem permissão para atender chamados');
            }
            
            $chamado = Chamado::findOrFail($id);
            
            if ($chamado->status !== 'aberto') {
                throw new \Exception('Este chamado já está '.$chamado->status);
            }
            
            $chamado->update([
                'atendente_ime' => Auth::user()->ime,
                'status' => 'em andamento',
                'data_atendimento' => now()
            ]);
            
            return redirect()->route('chamado.visualizar', $id)->with('success', 'Chamado em atendimento!');
            
        } catch (\Exception $e) {
            return redirect()->route('chamado.visualizar', $id)->with('error', $e->getMessage());
        }
    }

    /**
     * Exibe formulário para editar chamado
     */
    public function chamadoEditar($id, Request $request)
    {
        $this->checkLogin();
        
        if ($request->isMethod('post')) {
            $dados = $request->only(['titulo', 'descricao', 'prioridade', 'status']);
            
            Chamado::find($id)->update($dados);
            
            return redirect()->route('chamado.visualizar', $id)->with('success', 'Chamado atualizado com sucesso!');
        }
        
        $chamado = Chamado::findOrFail($id);
        
        if ($chamado->usuario_ime != Auth::user()->ime && 
            $chamado->atendente_ime != Auth::user()->ime) {
            return redirect()->route('chamado.index')->with('error', 'Você não tem permissão para editar este chamado');
        }
        
        return $this->loadPage('chamado.editar', ['chamado' => $chamado]);
    }

    /**
     * Conclui um chamado
     */
    public function chamadoConcluir($id)
    {
        $this->checkLogin();
        
        try {
            $userRole = Auth::user()->role;
            
            if (!in_array($userRole, ['admin', 'atendente'])) {
                throw new \Exception('Você não tem permissão para concluir chamados');
            }
            
            $chamado = Chamado::findOrFail($id);
            
            if ($chamado->status !== 'em andamento') {
                throw new \Exception('Este chamado precisa estar em andamento para ser concluído');
            }
            
            if ($chamado->atendente_ime != Auth::user()->ime && $userRole != 'admin') {
                throw new \Exception('Apenas o atendente responsável pode concluir este chamado');
            }
            
            $chamado->update([
                'status' => 'resolvido',
                'data_fechamento' => now()
            ]);
            
            return redirect()->route('chamado.visualizar', $id)->with('success', 'Chamado fechado com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->route('chamado.visualizar', $id)->with('error', $e->getMessage());
        }
    }

    /**
     * Visualiza um chamado
     */
    public function chamadoVisualizar($id)
    {
        $this->checkLogin();
        $chamado = Chamado::findOrFail($id);
        return $this->loadPage('chamado.visualizar', ['chamado' => $chamado]);
    }

    /**
     * Lista chamados do usuário
     */
    public function chamadoMeusChamados()
    {
        $this->checkLogin();
        $chamados = Chamado::where('usuario_ime', Auth::user()->ime)->get();
        return $this->loadPage('chamado.meus_chamados', ['chamados' => $chamados]);
    }

    /**
     * Exibe o formulário 20
     */
    public function form20()
    {
        $this->checkLogin();
        $dados = PkUsuario::where('ime_num', Auth::user()->ime)->first();
        return $this->loadPage('cadastros.form_20', ['dados' => $dados]);
    }

    /**
     * Define o grau para exibição de conteúdo
     */
    public function setGrau(Request $request)
    {
        $grau = (int) $request->input('grau');
        $ime = Auth::user()->ime;

        if (!empty($grau) && !empty($ime)) {
            $temAcesso = DB::table('pk_usuarios')
                          ->where('ime_num', $ime)
                          ->where('ativo_no_grau', '>=', $grau)
                          ->exists();
            
            if ($temAcesso) {
                $conteudos = ConteudoIead::where('grau', $grau)->get();
                
                if (view()->exists("iead.{$grau}")) {
                    return view("iead.{$grau}", [
                        'conteudos' => $conteudos,
                        'grau_atual' => $grau,
                        'usuario' => Auth::user()
                    ]);
                }
                
                abort(404);
            }
            
            return response('Acesso negado. Você não tem permissão para visualizar esse grau.', 403);
        }
        
        return response('Nenhum grau válido foi enviado ou usuário não autenticado.', 400);
    }

    /**
     * Busca usuário por IME
     */
    public function buscarPorIme($ime)
    {
        if (empty($ime)) {
            return response()->json(['error' => 'IME não fornecido'], 400);
        }

        $dados = PkUsuario::where('ime_num', $ime)->first();
        
        if (!$dados) {
            return response()->json(['error' => 'IME não encontrado'], 404);
        }

        $response = [
            'id_registro' => $dados->id_registro,
            'ime_num' => $dados->ime_num,
            'cadastro' => $dados->cadastro,
            'email' => $dados->email,
            'pai' => $dados->pai,
            'mae' => $dados->mae,
            'nascimento' => $dados->nascimento ? $dados->nascimento->format('d/m/Y') : '',
            // ... outros campos ...
        ];

        return response()->json($response);
    }

    /**
     * Gera PDF da ficha 20
     */
    public function gerarPdf(Request $request)
    {
        $this->checkLogin();

        $pdf = $this->MYPDF;
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);
        
        $pdf->SetCreator('Supremo Conselho');
        $pdf->SetAuthor('Supremo Conselho');
        $pdf->SetTitle('Cadastro Maçônico');
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();

        $logoPath = public_path('assets/images/logo_delit_curitiba.png');
        
        if (!file_exists($logoPath)) {
            error_log('Logo não encontrada em: ' . $logoPath);
        }
        
        $html = '
        <style>
            table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
            td { padding: 2px; vertical-align: middle; font-size: 9pt; }
            .header { width: 100%; margin-bottom: 10px; }
            .header td { text-align: center; font-size: 11pt; font-weight: bold; }
            .logo-cell { width: 20%; text-align: center; }
            .title-cell { width: 80%; text-align: left; padding-left: 10px; }
            .small-text { font-size: 8pt; }
            .section { background-color: #f0f0f0; font-weight: bold; padding: 3px; margin: 5px 0; }
            .table-padding > tbody > tr > td { padding: 2px; margin-bottom: 5px; }
        </style>
        
        <table class="header" border="0">
            <tr>
                <td class="logo-cell">
                    <img src="'.$logoPath.'" width="80">
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
                <td width="15%">Registro: '.$request->input('id_registro').'</td>
                <td width="85%">Nome: '.$request->input('cadastro').'</td>
            </tr>
        </table>';

        // ... continuação do HTML ...

        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf->Output('cadastro_maconico_'.$request->input('ime_num').'.pdf', 'D');
    }

    /**
     * Gerenciar conteúdos IEAD
     */
    public function gerenciarConteudosIead()
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        $conteudos = ConteudoIead::all();
        return $this->loadPage('gerenciar_conteudos_iead', ['conteudos' => $conteudos]);
    }

    /**
     * Criar conteúdo IEAD
     */
    public function criarConteudoIead(Request $request)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'titulo' => 'required',
                'descricao' => 'required',
                'grau' => 'required|numeric',
                'tipo_conteudo' => 'required',
                'arquivo' => 'required|file|mimes:mp4,jpg,jpeg,png,pdf,txt,docx|max:802400'
            ]);

            $path = $request->file('arquivo')->store('public/uploads/iead');
            
            $dados = [
                'titulo' => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                'grau' => $request->input('grau'),
                'tipo_conteudo' => $request->input('tipo_conteudo'),
                'caminho_arquivo' => Storage::url($path)
            ];

            ConteudoIead::create($dados);
            
            return redirect()->route('gerenciar.conteudos.iead')->with('success', 'Conteúdo salvo com sucesso!');
        }

        return $this->loadPage('form_conteudo_iead');
    }

    /**
     * Editar conteúdo IEAD
     */
    public function editarConteudoIead($id, Request $request)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'titulo' => 'required',
                'descricao' => 'required',
                'grau' => 'required|numeric',
                'tipo_conteudo' => 'required',
                'arquivo' => 'nullable|file|mimes:mp4,jpg,jpeg,png,pdf,txt,docx|max:20480'
            ]);

            $dados = $request->only(['titulo', 'descricao', 'grau', 'tipo_conteudo']);
            
            if ($request->hasFile('arquivo')) {
                $path = $request->file('arquivo')->store('public/uploads/iead');
                $dados['caminho_arquivo'] = Storage::url($path);
            }

            ConteudoIead::find($id)->update($dados);
            
            return redirect()->route('gerenciar.conteudos.iead')->with('success', 'Conteúdo atualizado com sucesso!');
        }

        $conteudo = ConteudoIead::findOrFail($id);
        return $this->loadPage('form_conteudo_iead', ['conteudo' => $conteudo]);
    }

    /**
     * Deletar conteúdo IEAD
     */
    public function deletarConteudoIead($id)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        ConteudoIead::destroy($id);
        return redirect()->route('gerenciar.conteudos.iead');
    }

    /**
     * Página não encontrada
     */
    public function paginaNaoEncontrada()
    {
        return view('404');
    }

    /**
     * Listar planilhas
     */
    public function planilhas()
    {
        $this->checkLogin();
        
        $grau = Auth::user()->role == 'admin' ? null : Auth::user()->grau;
        $planilhas = Planilha::when($grau, function($query, $grau) {
                            return $query->where('grau_acesso', '<=', $grau);
                        })
                        ->get();
        
        return $this->loadPage('planilhas', ['planilhas' => $planilhas]);
    }

    /**
     * Visualizar planilha
     */
    public function visualizarPlanilha($id)
    {
        $this->checkLogin();
        $planilha = Planilha::findOrFail($id);
        return $this->loadPage('visualizar_planilha', ['planilha' => $planilha]);
    }

    /**
     * Adicionar planilha
     */
    public function adicionarPlanilha(Request $request)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'nome' => 'required',
                'grau_acesso' => 'required|numeric',
                'arquivo' => 'required|file|mimes:pdf|max:20480'
            ]);

            $path = $request->file('arquivo')->store('public/uploads/planilhas');
            
            $dados = [
                'nome' => $request->input('nome'),
                'caminho' => Storage::url($path),
                'grau_acesso' => $request->input('grau_acesso')
            ];

            Planilha::create($dados);
            
            return redirect()->route('planilhas')->with('success', 'Arquivo PDF adicionado com sucesso!');
        }

        return $this->loadPage('form_planilha');
    }

    /**
     * Editar planilha
     */
    public function editarPlanilha($id, Request $request)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'nome' => 'required',
                'grau_acesso' => 'required|numeric',
                'arquivo' => 'nullable|file|mimes:pdf|max:20480'
            ]);

            $dados = $request->only(['nome', 'grau_acesso']);
            
            if ($request->hasFile('arquivo')) {
                $path = $request->file('arquivo')->store('public/uploads/planilhas');
                $dados['caminho'] = Storage::url($path);
            }

            Planilha::find($id)->update($dados);
            
            return redirect()->route('planilhas')->with('success', 'Arquivo PDF atualizado com sucesso!');
        }

        $planilha = Planilha::findOrFail($id);
        return $this->loadPage('form_planilha', ['planilha' => $planilha]);
    }

    /**
     * Deletar planilha
     */
    public function deletarPlanilha($id)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        Planilha::destroy($id);
        return redirect()->route('planilhas');
    }

    /**
     * Cadastrar usuário (Passo 1)
     */
    public function cadastrarUsuario(Request $request)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Apenas administradores podem cadastrar usuários.');
        }

        $ultimoIme = Usuario::max('ime');
        
        if ($request->isMethod('post')) {
            $request->validate([
                'ime' => 'required|regex:/^\d{3}\.\d{3}$/|unique:usuarios,ime',
                'nome' => 'required|min:5',
                'email' => 'required|email|unique:usuarios,email',
                'senha' => 'required|min:6',
                'confirma_senha' => 'required|same:senha'
            ]);

            $ime = $request->input('ime');
            $senhaOriginal = $request->input('senha');
            
            $dados = [
                'ime' => $ime,
                'nome' => $request->input('nome'),
                'email' => $request->input('email'),
                'senha' => hash('sha256', $senhaOriginal),
                'role' => $request->input('role', 'usuario'),
                'status' => 'ativo',
                'created_at' => now()
            ];

            $usuario = Usuario::create($dados);
            
            if ($usuario) {
                $request->session()->put('senha_original', $senhaOriginal);
                return redirect()->route('cadastrar.pk.usuario', $dados['ime'])
                                ->with('success', 'Usuário cadastrado com sucesso! Continue o cadastro.');
            }
            
            return redirect()->route('cadastrar.usuario')->with('error', 'Erro ao cadastrar usuário.');
        }

        return $this->loadPage('cadastrar_usuario', ['ultimo_ime' => $ultimoIme]);
    }

    /**
     * Cadastrar PK Usuário (Passo 2)
     */
    public function cadastrarPkUsuario($ime, Request $request)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        $request->validate([
            'cic' => 'required|cpf|unique:pk_usuarios,cic',
            // ... outras validações ...
        ]);

        if ($request->isMethod('post')) {
            $request->session()->put('pk_usuario_form', $request->all());
        }
        
        if ($request->isMethod('post')) {
            try {
\Illuminate\Support\Facades\DB::beginTransaction();

                // Dados para pk_usuarios
                $dados = [
                    'ime_num' => $ime,
                    'cadastro' => $request->input('cadastro'),
                    'cic' => preg_replace('/[^0-9]/', '', $request->input('cic')),
                    'email' => $request->input('email'),
                    'ativo_no_grau' => $request->input('ativo_no_grau', 1),
                    // ... outros campos ...
                ];

                PkUsuario::create($dados);

                // Atualiza dados na tabela usuarios
                Usuario::where('ime', $ime)->update([
                    'grau' => $dados['ativo_no_grau'],
                    'email' => $dados['email'],
                    'cpf' => $dados['cic']
                ]);

\Illuminate\Support\Facades\DB::commit();

                $request->session()->forget('pk_usuario_form');
                
                $usuario = Usuario::where('ime', $ime)->first();
                $senhaOriginal = $request->session()->get('senha_original');
                
                $assunto = '📬 Cadastro Concluído - Portal Delit Curitiba';
                
                $corpo = "
                    <div style='padding: 20px; background-color: #f9f9f9;'>
                        <h2 style='color:#960018;'>Olá, {$usuario->nome}!</h2>
                        <p>Seu cadastro no sistema foi concluído com sucesso.</p>
                        
                        <div style='background-color: #e9ecef; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                            <h3 style='color: #960018; margin-top: 0;'>Seus dados de acesso:</h3>
                            <p><strong>IME (CIM):</strong> {$ime}</p>
                            <p><strong>Email:</strong> {$usuario->email}</p>
                            <p><strong>Senha:</strong> {$senhaOriginal}</p>
                        </div>
                        
                        <p style='margin-bottom: 20px;'>Para acessar o sistema, clique no botão abaixo:</p>
                        
                        <a href='".route('login')."' 
                           style='display: inline-block; background-color: #960018; color: #ffffff; 
                                  padding: 10px 20px; text-decoration: none; border-radius: 5px; 
                                  font-weight: bold;'>
                            Acessar o Portal
                        </a>
                    </div>
                ";
                
                try {
                    Mail::send([], [], function($message) use ($usuario, $assunto, $corpo) {
                        $message->to($usuario->email)
                                ->subject($assunto)
                                ->html($corpo);
                    });
                    
                    $request->session()->forget('senha_original');
                    return redirect()->route('listar.usuarios')
                                    ->with('success', 'Cadastro complementar realizado com sucesso! Um email foi enviado com as credenciais.');
                } catch (\Exception $e) {
                    $request->session()->forget('senha_original');
                    return redirect()->route('listar.usuarios')
                                    ->with('warning', 'Cadastro realizado, mas houve um erro ao enviar o email. Por favor, informe as credenciais ao usuário.');
                }
                
            } catch (\Exception $e) {
\Illuminate\Support\Facades\DB::rollBack();
                return redirect()->route('cadastrar.pk.usuario', $ime)
                                ->with('error', $e->getMessage());
            }
        }

        $usuario = Usuario::where('ime', $ime)->first();
        $formData = $request->session()->get('pk_usuario_form');
        
        return $this->loadPage('form_pk_usuario', [
            'usuario' => $usuario,
            'form_data' => $formData
        ]);
    }

    /**
     * Deletar usuário
     */
    public function deletarUsuario($ime)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        Usuario::where('ime', $ime)->delete();
        return redirect()->route('listar.usuarios')->with('success', 'Usuário deletado com sucesso!');
    }

    /**
     * Listar usuários com paginação
     */
    public function listarUsuarios(Request $request)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        $filtros = $request->only(['nome', 'ime', 'grau']);
        
        $usuarios = Usuario::query()
            ->when($filtros['nome'], function($query, $nome) {
                return $query->where('nome', 'like', "%{$nome}%");
            })
            ->when($filtros['ime'], function($query, $ime) {
                return $query->where('ime', 'like', "%{$ime}%");
            })
            ->when($filtros['grau'], function($query, $grau) {
                return $query->where('grau', $grau);
            })
            ->paginate(100);
        
        return $this->loadPage('listar_usuarios', [
            'usuarios' => $usuarios,
            'total_usuarios' => $usuarios->total()
        ]);
    }

    /**
     * Editar usuário
     */
    public function editarUsuario($ime)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        $usuario = Usuario::where('ime', $ime)->first();
        $pkUsuario = PkUsuario::where('ime_num', $ime)->first();
        
        return $this->loadPage('editar_usuario', [
            'usuario' => $usuario,
            'pk_usuario' => $pkUsuario
        ]);
    }

    /**
     * Salvar edição de usuário
     */
    public function salvarEdicaoUsuario($id, Request $request)
    {
        $this->checkLogin();
        
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        if ($request->isMethod('post')) {
            try {
\Illuminate\Support\Facades\DB::beginTransaction();

                // Atualiza dados do usuário
                $dadosUsuario = $request->only(['nome', 'email', 'role', 'grau']);
                Usuario::find($id)->update($dadosUsuario);

                // Atualiza dados do pk_usuario
                $dadosPkUsuario = $request->only([
                    'cadastro', 'pai', 'mae', 'nascimento', 'cidade1', 'estado1', 
                    'nacionalidade', 'profissao', 'endereco_residencial', 'bairro',
                    'cidade', 'estado', 'cep', 'telefone_residencial', 'telefone_comercial',
                    'celular', 'estado_civil', 'numero_filhos', 'sexo_m', 'sexo_f',
                    'esposa', 'nascida', 'casamento'
                ]);
                
                PkUsuario::where('ime_num', $request->input('ime_num'))
                         ->update($dadosPkUsuario);

                \Illuminate\Support\Facades\DB::commit();
                
                return redirect()->route('listar.usuarios')
                                ->with('success', 'Usuário atualizado com sucesso!');
                
            } catch (\Exception $e) {
\Illuminate\Support\Facades\DB::rollBack();
                return redirect()->route('editar.usuario', $request->input('ime_num'))
                                ->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Servir vídeo com suporte a streaming
     */
    public function servirVideo($id)
    {
        $this->checkLogin();
        
        $conteudo = ConteudoIead::findOrFail($id);
        
        if ($conteudo->tipo_conteudo !== 'video') {
            abort(404);
        }
        
        $ime = Auth::user()->ime;
        $temAcesso = Usuario::where('ime', $ime)
                          ->where('grau', '>=', $conteudo->grau)
                          ->exists();
        
        if (!$temAcesso) {
            abort(404);
        }
        
        $caminhoArquivo = storage_path('app/public/' . str_replace('storage/', '', $conteudo->caminho_arquivo));
        
        if (!file_exists($caminhoArquivo)) {
            abort(404);
        }
        
        $size = filesize($caminhoArquivo);
        $start = 0;
        $end = $size - 1;
        
        header('Content-Type: video/mp4');
        header('Accept-Ranges: bytes');
        
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
            header('HTTP/1.1 206 Partial Content');
        }
        
        header("Content-Range: bytes $start-$end/$size");
        header('Content-Length: ' . $length);
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        
        $buffer = 1024 * 8;
        $fp = fopen($caminhoArquivo, 'rb');
        fseek($fp, $start);
        
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
        
            // Primeiro verifica na tabela pk_usuarios
            $pkUsuario = PkUsuario::where('ime_num', $ime)->first();
        
            if (!$pkUsuario) {
                return back()->withInput()->with('error', 'IME não encontrado. Verifique as informações ou entre em contato com o administrador.');
            }
            
            if ($pkUsuario->cic !== $cpf) {
                return back()->withInput()->with('error', 'CPF não confere com o IME informado. Verifique as informações.');
            }
            
            // Agora verifica na tabela usuarios
            $usuario = Usuario::where('ime', $ime)->first();
            
            if (!$usuario) {
                return back()->withInput()->with('error', 'Usuário não encontrado. Entre em contato com o administrador.');
            }
            
            if (empty($usuario->email)) {
                return back()->withInput()->with('error', 'E-mail não cadastrado. Entre em contato com o administrador.');
            }
            
            $senha = $this->gerarSenhaAleatoria();
            
            // Atualiza a senha do usuário
            try {
                Usuario::where('ime', $ime)->update(['senha' => hash('sha256', $senha)]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erro ao atualizar senha: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Erro ao atualizar senha. Por favor, tente novamente.');
            }
            
            try {
                Mail::to($usuario->email)
                    ->send(new \App\Mail\PrimeiroAcesso($ime, $senha, $pkUsuario->cadastro));
                
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

    public function verificaAcessoGrau($ime, $grau)
    {
        return DB::table('pk_usuarios')
                ->where('ime_num', $ime)
                ->where('ativo_no_grau', $grau)
                ->exists();
    }
}
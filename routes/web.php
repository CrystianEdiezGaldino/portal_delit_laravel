<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\VirtualCardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DelegacyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\IeadController;
use App\Http\Controllers\AnnuityController;
use App\Http\Controllers\ElevationController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controlador;
use App\Http\Controllers\FixCaminhoArquivosController;
use App\Http\Controllers\CadastroController;

// Authentication Routes
Route::get('/', [Controlador::class, 'login'])->name('login');
Route::post('/login', [Controlador::class, 'login'])->name('login.post');
Route::get('/logout', [Controlador::class, 'logout'])->name('logout');
Route::post('/logout', [Controlador::class, 'logout'])->name('logout.post');

// Rota de Primeiro Acesso (pública)
Route::post('/primeiro-acesso', [Controlador::class, 'primeiroAcesso'])->name('primeiro.acesso');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Controlador::class, 'dashboard'])->name('dashboard');
    Route::get('/tutorials', [TutorialController::class, 'index'])->name('tutorials');
    
    // Financial Routes
    Route::prefix('financial')->group(function () {
        Route::get('/', [FinancialController::class, 'dashboard'])->name('financial.dashboard');
        Route::get('/fees', [FinancialController::class, 'fees'])->name('financial.fees');
        Route::get('/receipts', [FinancialController::class, 'receipts'])->name('financial.receipts');
        Route::get('/receipts/create', [FinancialController::class, 'createReceipt'])->name('financial.receipts.create');
        Route::get('/reports', [FinancialController::class, 'reports'])->name('financial.reports');
    });

    Route::get('/virtual-card', [VirtualCardController::class, 'index'])->name('virtual.card');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletins');
    Route::get('/publications', [PublicationController::class, 'index'])->name('publications');
    
    // Members Routes
    Route::prefix('members')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('members');
        Route::get('/active', [MemberController::class, 'active'])->name('members.active');
        Route::get('/inactive', [MemberController::class, 'inactive'])->name('members.inactive');
    });

    Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
    Route::get('/delegacies', [DelegacyController::class, 'index'])->name('delegacies');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/club-montezuma', [ClubController::class, 'index'])->name('club');
    // IEAD Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/iead', [IeadController::class, 'index'])->name('iead.index');
        Route::get('/iead/set-grau', [IeadController::class, 'setGrau'])->name('iead.set-grau');
        Route::post('/iead/set-grau', [IeadController::class, 'setGrau']);
        Route::get('/iead/gerenciar', [IeadController::class, 'gerenciarConteudos'])->name('gerenciar.conteudos.iead');
        Route::get('/iead/criar', [IeadController::class, 'criarConteudo'])->name('criar.conteudo.iead');
        Route::post('/iead/criar', [IeadController::class, 'criarConteudo']);
        Route::get('/iead/editar/{id}', [IeadController::class, 'editarConteudo'])->name('editar.conteudo.iead');
        Route::post('/iead/editar/{id}', [IeadController::class, 'editarConteudo']);
        Route::delete('/iead/deletar/{id}', [IeadController::class, 'deletarConteudo'])->name('deletar.conteudo.iead');
        Route::get('/iead/video/{id}', [IeadController::class, 'servirVideo'])->name('servir.video.iead');
        Route::get('/annuities', [AnnuityController::class, 'index'])->name('annuities');
        Route::get('/elevations', [ElevationController::class, 'index'])->name('elevations');
        Route::get('/digital-diploma', [DiplomaController::class, 'index'])->name('digital.diploma');
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');

        // User Profile Routes
        Route::get('/user/profile', [ProfileController::class, 'show'])->name('user.profile');
        Route::get('/user/settings', [ProfileController::class, 'settings'])->name('user.settings');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        
        // Cadastro de usuários
        Route::prefix('cadastro')->group(function () {
            Route::get('/etapa1', [CadastroController::class, 'etapa1'])->name('cadastro.etapa1');
            Route::post('/etapa1', [CadastroController::class, 'etapa1Process'])->name('cadastro.etapa1.process');
            Route::get('/etapa2/{ime}', [CadastroController::class, 'etapa2'])->name('cadastro.etapa2');
            Route::post('/etapa2/{ime}', [CadastroController::class, 'etapa2Process'])->name('cadastro.etapa2.process');
        });

        // Listagem e gerenciamento de usuários
        Route::prefix('usuarios')->group(function () {
            Route::get('/listar', [CadastroController::class, 'listarUsuarios'])->name('listar.usuarios');
            Route::get('/editar/{ime}', [CadastroController::class, 'editarUsuario'])->name('editar.usuario');
            Route::post('/salvar/{ime}', [CadastroController::class, 'salvarEdicaoUsuario'])->name('salvar.edicao.usuario');
            Route::delete('/deletar/{ime}', [CadastroController::class, 'deletarUsuario'])->name('deletar.usuario');
        });
        
        // Planilhas
        Route::get('/planilhas', [Controlador::class, 'planilhas'])->name('planilhas');
        Route::get('/planilhas/visualizar/{id}', [Controlador::class, 'visualizarPlanilha'])->name('visualizar.planilha');
        Route::get('/planilhas/adicionar', [Controlador::class, 'adicionarPlanilha'])->name('adicionar.planilha');
        Route::post('/planilhas/adicionar', [Controlador::class, 'adicionarPlanilha']);
        Route::get('/planilhas/editar/{id}', [Controlador::class, 'editarPlanilha'])->name('editar.planilha');
        Route::post('/planilhas/editar/{id}', [Controlador::class, 'editarPlanilha']);
        Route::get('/planilhas/deletar/{id}', [Controlador::class, 'deletarPlanilha'])->name('deletar.planilha');
        
        // Chamados
        Route::get('/chamados', [Controlador::class, 'chamadoIndex'])->name('chamado.index');
        Route::get('/chamados/novo', [Controlador::class, 'chamadoNovo'])->name('chamado.novo');
        Route::post('/chamados/abrir', [Controlador::class, 'chamadoAbrir'])->name('chamado.abrir');
        Route::get('/chamados/visualizar/{id}', [Controlador::class, 'chamadoVisualizar'])->name('chamado.visualizar');
        Route::get('/chamados/editar/{id}', [Controlador::class, 'chamadoEditar'])->name('chamado.editar');
        Route::post('/chamados/editar/{id}', [Controlador::class, 'chamadoEditar']);
        Route::get('/chamados/atender/{id}', [Controlador::class, 'chamadoAtender'])->name('chamado.atender');
        Route::get('/chamados/concluir/{id}', [Controlador::class, 'chamadoConcluir'])->name('chamado.concluir');
        Route::get('/chamados/meus', [Controlador::class, 'chamadoMeusChamados'])->name('chamado.meus');
    }); // End of IEAD middleware group
}); // End of main auth middleware group

// Rota temporária para migrar caminhos de arquivos
Route::get('/fix-caminhos-arquivos', [FixCaminhoArquivosController::class, 'migrarArquivos']);

// Rotas de cadastro
Route::get('/cadastro/etapa1', [CadastroController::class, 'etapa1'])->name('cadastro.etapa1');
Route::post('/cadastro/etapa1/process', [CadastroController::class, 'etapa1Process'])->name('cadastro.etapa1.process');
Route::get('/cadastro/etapa2/{ime}', [CadastroController::class, 'etapa2'])->name('cadastro.etapa2');
Route::post('/cadastro/etapa2/process/{ime}', [CadastroController::class, 'etapa2Process'])->name('cadastro.etapa2.process');
Route::get('/cadastro/sucesso/{ime}', [CadastroController::class, 'sucesso'])->name('cadastro.sucesso');
Route::post('/cadastro/enviar-senha/{ime}', [CadastroController::class, 'enviarSenha'])->name('cadastro.enviar-senha');

// Rotas de gerenciamento de usuários
Route::prefix('usuarios')->group(function () {
    Route::get('/listar', [CadastroController::class, 'listarUsuarios'])->name('listar.usuarios');
    Route::get('/editar/{ime}', [CadastroController::class, 'editarUsuario'])->name('editar.usuario');
    Route::post('/salvar/{ime}', [CadastroController::class, 'salvarEdicaoUsuario'])->name('salvar.edicao.usuario');
    Route::delete('/deletar/{ime}', [CadastroController::class, 'deletarUsuario'])->name('deletar.usuario');
});

// Rota de primeiro acesso
Route::post('/primeiro-acesso', [CadastroController::class, 'primeiroAcesso'])->name('primeiro.acesso');

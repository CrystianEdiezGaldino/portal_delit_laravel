@php
    $routeName = Route::currentRouteName();
    $titles = [
        'dashboard' => 'Dashboard',
        'tutorials' => 'Tutoriais',
        'financial.dashboard' => 'Dashboard Financeiro',
        'financial.fees' => 'Taxas',
        'financial.receipts' => 'Recibos',
        'financial.receipts.create' => 'Gerar Recibo',
        'financial.reports' => 'Relatórios',
        'virtual.card' => 'Carteira Virtual',
        'calendar' => 'Calendário',
        'bulletins' => 'Boletins',
        'publications' => 'Publicações',
        'members' => 'Membros',
        'members.active' => 'Membros Ativos',
        'members.inactive' => 'Membros Inativos',
        'registration' => 'Cadastro',
        'delegacies' => 'Delegacias',
        'contact' => 'Contato',
        'club' => 'Clube Montezuma',
        'iead.index' => 'IEAD - Instruções',
        'annuities' => 'Anuidades',
        'elevations' => 'Elevações',
        'digital.diploma' => 'Diploma Digital',
        'tickets' => 'Chamados',
        'tickets.create' => 'Abrir Chamado',
        'user.profile' => 'Perfil',
        'user.settings' => 'Configurações',
        'notifications' => 'Notificações'
    ];
    
    $pageTitle = $titles[$routeName] ?? ucfirst(str_replace(['.', '_'], ' ', $routeName));
@endphp

<header class="main-header">
    <div class="d-flex align-items-center">
        <h1 class="page-title">{{ $pageTitle }}</h1>
        <nav aria-label="breadcrumb">
           
        </nav>
    </div>
    <div class="header-actions">
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i>
                {{ Auth::user()->nome }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Sair</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<style>
    .user-info {
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        margin: 10px 0;
    }
    .user-info p {
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    .user-info strong {
        color: #495057;
    }
</style>
@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-header">
            <div>
                <h1>Bem-vindo, {{ Auth::user()->name }}</h1>
                <p class="text-muted">{{ now()->format('l, d \d\e F \d\e Y') }}</p>
            </div>
            <div class="quick-actions">
                <button class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nova Solicitação</button>
                <button class="btn btn-outline-primary"><i class="bi bi-download"></i> Relatórios</button>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-primary-soft">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-details">
                <h3>Próximo Evento</h3>
                <p class="stat-value">15 Março</p>
                <p class="stat-label">Reunião Mensal</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-success-soft">
                <i class="bi bi-credit-card"></i>
            </div>
            <div class="stat-details">
                <h3>Status Anuidade</h3>
                <p class="stat-value">R$ 265,00</p>
                <p class="stat-label text-warning">Pendente</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-info-soft">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-details">
                <h3>Grau Atual</h3>
                <p class="stat-value">{{ Auth::user()->grau ?? '3º' }}</p>
                <p class="stat-label">Mestre Maçom</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-warning-soft">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-details">
                <h3>Tempo de Ordem</h3>
                <p class="stat-value">2 Anos</p>
                <p class="stat-label">Desde 2022</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Financial Overview -->
        <div class="dashboard-card financial-overview">
            <div class="card-header">
                <h2>Visão Financeira</h2>
                <div class="dropdown">
                    <button class="btn btn-link" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Ver Detalhes</a></li>
                        <li><a class="dropdown-item" href="#">Gerar Relatório</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="financial-status">
                    <div class="status-item">
                        <span class="status-label">Anuidade 2024</span>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                        <span class="status-value text-success">Pago</span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">Anuidade 2025</span>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 0%"></div>
                        </div>
                        <span class="status-value text-warning">Pendente</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="dashboard-card activities">
            <div class="card-header">
                <h2>Atividades Recentes</h2>
                <a href="#" class="btn btn-link">Ver Todas</a>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    <div class="activity-item">
                        <div class="activity-icon bg-primary">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">Diploma Digital Emitido</p>
                            <p class="activity-time">Hoje, 14:30</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-success">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">Pagamento Processado</p>
                            <p class="activity-time">Ontem, 16:45</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-info">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">Presença Confirmada</p>
                            <p class="activity-time">15/02/2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="dashboard-card quick-access">
            <div class="card-header">
                <h2>Acesso Rápido</h2>
            </div>
            <div class="card-body">
                <div class="quick-access-grid">
                    <a href="#" class="quick-access-item">
                        <i class="bi bi-credit-card-2-front"></i>
                        <span>Carteira Virtual</span>
                    </a>
                    <a href="#" class="quick-access-item">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Diplomas</span>
                    </a>
                    <a href="#" class="quick-access-item">
                        <i class="bi bi-calendar-event"></i>
                        <span>Eventos</span>
                    </a>
                    <a href="#" class="quick-access-item">
                        <i class="bi bi-journal-text"></i>
                        <span>Documentos</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="dashboard-card events">
            <div class="card-header">
                <h2>Próximos Eventos</h2>
                <a href="#" class="btn btn-link">Ver Calendário</a>
            </div>
            <div class="card-body">
                <div class="event-list">
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">15</span>
                            <span class="month">MAR</span>
                        </div>
                        <div class="event-details">
                            <h4>Reunião Mensal</h4>
                            <p><i class="bi bi-clock"></i> 19:30 - 21:30</p>
                            <p><i class="bi bi-geo-alt"></i> Sede Central</p>
                        </div>
                    </div>
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">22</span>
                            <span class="month">MAR</span>
                        </div>
                        <div class="event-details">
                            <h4>Cerimônia de Elevação</h4>
                            <p><i class="bi bi-clock"></i> 20:00 - 22:00</p>
                            <p><i class="bi bi-geo-alt"></i> Templo Principal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection
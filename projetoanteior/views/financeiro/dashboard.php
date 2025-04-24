<style>
/* Reset do tooltip */
#unitip {
    position: fixed !important;
    left: 0 !important;
    top: 0 !important;
    transform: none !important;
    animation: none !important;
    transition: none !important;
    opacity: 1 !important;
    pointer-events: none !important;
    display: none !important;
}

/* Variáveis de cores */
:root {
    --primary-color: #960018;
    --primary-light: rgba(150, 0, 24, 0.1);
    --secondary-color: #54595F;
    --text-color: #7A7A7A;
    --bg-light: #f8f9fa;
    --transition-speed: 0.3s;
    --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --hover-transform: translateY(-3px);
    --font-family: 'Roboto', sans-serif;
    --border-radius: 12px;
    --success-color: #1cc88a;
    --warning-color: #f6c23e;
}

/* Animações */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(50px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-50px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

.card {
    padding: 0.5rem;
    animation: fadeIn 0.6s ease-out;
}

/* Estilos gerais */
.container-fluid {
    padding: 2rem;
    background-color: var(--bg-light);
    font-family: var(--font-family);
    color: var(--text-color);
    animation: fadeIn 0.5s ease-out;
}

/* Header estilizado */
.h3.text-gray-800 {
    color: var(--primary-color);
    font-weight: 700;
    margin-bottom: 1.5rem;
    position: relative;
    font-size: 1.75rem;
    letter-spacing: 0.5px;
    animation: slideInLeft 0.7s ease-out;
}

.h3.text-gray-800::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 80px;
    height: 4px;
    background-color: var(--primary-color);
    border-radius: 2px;
    animation: slideInLeft 0.9s ease-out;
}

/* Botão Novo Recibo */
.btn-primary {
    background-color: var(--primary-color);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    transition: all var(--transition-speed);
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(150, 0, 24, 0.2);
    font-size: 1rem;
    letter-spacing: 0.5px;
    animation: slideInRight 0.7s ease-out;
    position: relative;
    overflow: hidden;
}

.btn-primary:hover {
    background-color: #7a0014;
    transform: var(--hover-transform);
    box-shadow: 0 6px 12px rgba(150, 0, 24, 0.3);
}

.btn-primary::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 5px;
    height: 5px;
    background: rgba(255, 255, 255, 0.5);
    opacity: 0;
    border-radius: 100%;
    transform: scale(1, 1) translate(-50%);
    transform-origin: 50% 50%;
}

.btn-primary:hover::after {
    animation: ripple 1s ease-out;
}

@keyframes ripple {
    0% {
        transform: scale(0, 0);
        opacity: 0.5;
    }
    100% {
        transform: scale(20, 20);
        opacity: 0;
    }
}

/* Cards de estatísticas */
.card {
    border: none;
    border-radius: var(--border-radius);
    transition: all var(--transition-speed);
    box-shadow: var(--card-shadow);
    background-color: white;
    overflow: hidden;
    position: relative;
}

.card:hover {
    transform: var(--hover-transform);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.border-left-primary {
    border-left: 5px solid var(--primary-color) !important;
    animation-delay: 0.1s;
}

.border-left-warning {
    border-left: 5px solid var(--warning-color) !important;
    animation-delay: 0.3s;
}

.border-left-success {
    border-left: 5px solid var(--success-color) !important;
    animation-delay: 0.5s;
}

/* Ícones nos cards */
.text-gray-300 {
    color: #dddddd;
}

.fa-2x {
    font-size: 2.5rem;
    opacity: 0.8;
    transition: all var(--transition-speed);
}

.card:hover .fa-2x {
    opacity: 1;
    transform: scale(1.1) rotate(5deg);
    color: var(--primary-color);
}

/* Efeito de loading para números */
.h5.mb-0.font-weight-bold.text-gray-800 {
    position: relative;
    overflow: hidden;
    animation: countUp 1.5s ease-out forwards;
}

@keyframes countUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Tabela de recibos */
.table-responsive {
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    overflow: hidden;
    animation: fadeIn 0.8s ease-out;
}

.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead th {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 1.2rem 1rem;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
}

.table thead th::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    animation: shimmer 2s infinite;
}

.table tbody tr {
    transition: background-color var(--transition-speed);
    animation: fadeIn 0.5s ease-out;
    animation-fill-mode: both;
}

.table tbody tr:nth-child(1) { animation-delay: 0.1s; }
.table tbody tr:nth-child(2) { animation-delay: 0.2s; }
.table tbody tr:nth-child(3) { animation-delay: 0.3s; }
.table tbody tr:nth-child(4) { animation-delay: 0.4s; }
.table tbody tr:nth-child(5) { animation-delay: 0.5s; }

.table tbody tr:hover {
    background-color: var(--primary-light);
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid rgba(0,0,0,0.05);
}

/* Badges de status */
.badge {
    padding: 0.6rem 1.2rem;
    border-radius: 50px;
    font-weight: 600;
    letter-spacing: 0.5px;
    font-size: 0.75rem;
    text-transform: uppercase;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

.badge-success {
    background-color: var(--success-color);
    animation: pulse 2s linear;
}

.badge-warning {
    background-color: var(--warning-color);
}

/* Botões de ação */
.btn-info, .btn-secondary {
    border: none;
    padding: 0.6rem;
    border-radius: 8px;
    transition: all var(--transition-speed);
    margin: 0 3px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.btn-info {
    background-color: var(--primary-color);
}

.btn-secondary {
    background-color: var(--secondary-color);
}

.btn-info:hover, .btn-secondary:hover {
    transform: var(--hover-transform);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.btn-info::before, .btn-secondary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: all 0.6s;
}

.btn-info:hover::before, .btn-secondary:hover::before {
    left: 100%;
}

/* Card header personalizado */
.card-header {
    background-color: white;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
}

.card-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background-color: var(--primary-color);
    transition: width 0.5s ease;
}

.card:hover .card-header::after {
    width: 100%;
}

.font-weight-bold.text-primary {
    color: var(--primary-color) !important;
    font-size: 1.2rem;
    letter-spacing: 0.5px;
}

/* Alerta personalizado */
.alert-info {
    background-color: rgba(150, 0, 24, 0.1);
    border: none;
    color: var(--primary-color);
    border-radius: var(--border-radius);
    padding: 1.2rem;
    font-weight: 500;
    box-shadow: var(--card-shadow);
    animation: fadeIn 0.5s ease-out;
    position: relative;
    overflow: hidden;
}

.alert-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background-color: var(--primary-color);
    animation: pulse 2s infinite;
}

/* Mensagem vazia */
.text-muted {
    color: var(--text-color) !important;
    font-style: italic;
    font-weight: 500;
    animation: fadeIn 0.8s ease-out;
}

/* Responsividade para telas menores */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .table thead th {
        padding: 0.8rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .table td {
        padding: 0.8rem 0.5rem;
    }
    
    .badge {
        padding: 0.4rem 0.8rem;
    }
}
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Dashboard Financeiro</h1>
        <a href="<?= base_url('financeiro/gerar') ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Novo Recibo
        </a>
    </div>
    
    <?php if(isset($status_dados) && !array_filter($status_dados)): ?>
        <div class="alert alert-info">
            O módulo financeiro ainda não possui dados cadastrados.
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de Recibos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $dashboard['total_recibos'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Recibos Pendentes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $dashboard['recibos_pendentes'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Receita do Mês</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                R$ <?= number_format($dashboard['receita_mes'] ?? 0, 2, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recibos Recentes -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Recibos Recentes</h6>
            <a href="<?= base_url('financeiro/recibos') ?>" class="btn btn-sm btn-primary">
                Ver Todos
            </a>
        </div>
        <div class="card-body">
            <?php if(empty($recibos_recentes)): ?>
                <div class="text-center py-3">
                    <p class="text-muted">Nenhum recibo encontrado.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>IME</th>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recibos_recentes as $recibo): ?>
                            <tr>
                                <td><?= $recibo['id'] ?></td>
                                <td><?= $recibo['ime'] ?></td>
                                <td><?= $recibo['nome_usuario'] ?? 'N/A' ?></td>
                                <td>R$ <?= number_format($recibo['valor_pago'], 2, ',', '.') ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($recibo['data_pagamento'])) ?></td>
                                <td>
                                    <span class="badge badge-<?= $recibo['status_pagamento'] == 'confirmado' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($recibo['status_pagamento']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('financeiro/visualizar_recibo/'.$recibo['id']) ?>" 
                                       class="btn btn-sm btn-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('financeiro/gerar_pdf_recibo/'.$recibo['id']) ?>" 
                                       class="btn btn-sm btn-secondary" title="Gerar PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
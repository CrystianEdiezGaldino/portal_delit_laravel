<style>
    /* Adicione estes estilos ao seu arquivo novo.css */

/* Divisor no menu */
.nav-divider {
    height: 1px;
    background-color: rgb(117 117 117 / 10%);
    margin: 1rem 0;
}

/* Ajuste para grupos de menu */
.nav-menu {
    padding: 1rem 0;

    overflow-y: auto;
    padding: 10px;
}

/* Estilização da scrollbar */
.nav-menu::-webkit-scrollbar {
    width: 4px;
}

.nav-menu::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.nav-menu::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
}

/* Ajuste para ícones */
.nav-link i {
    width: 20px;
    text-align: center;
    margin-right: 10px;
    font-size: 1.1rem;
}

/* Destaque para itens especiais */
.nav-item a[href*="clube"],
.nav-item a[href*="iead"] {
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Submenu ajustado */
.submenu {
    padding-left: 0.5rem;
}

/* Animação suave para o menu arrow */
.menu-arrow {
    transition: transform 0.3s ease;
}

.nav-link[aria-expanded="true"] .menu-arrow {
    transform: rotate(-180deg);
}
.nav-item.active .nav-link {
    background-color: var(--primary);
    text-decoration: none;
    border-radius: 8px;
    transition: all var(--transition-speed) ease;
    white-space: nowrap;
    color: white;
}

/* Para funcionar no mobile isso aqui ajusta o tamanho da lagura quando está aberto  */
@media (max-width: 768px) {
    .sidebar {
        margin-left: calc(var(--sidebar-width)* -0);
    }
}
</style>
<div class="main-container">
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo base_url('controlador'); ?>" class="brand-link">
                <span class="brand-text">Delit Curitiba</span>
                <span class="brand-mini"></span>
            </a>
            <button type="button" id="sidebarCollapse" class="btn">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>

        <ul class="nav-menu">
             <!-- Tutoriais -->
             <li class="nav-item <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                    <i class="bi bi-play-circle"></i>
                    <span>Dashboard</span>
                </a>
            </li>

         
            <?php if ($user_data['ativo_no_grau'] == 33): ?>
                   <!-- Tutoriais -->
            <li class="nav-item <?php echo ($current_page == 'tutoriais') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('tutoriais'); ?>" class="nav-link">
                    <i class="bi bi-play-circle"></i>
                    <span>Tutoriais</span>
                </a>
            </li>
            <?php endif; ?>



         <!-- Menu Financeiro - Apenas para admin e atendente -->
         <?php if (in_array($this->session->userdata('user_data')['role'], ['admin', 'atendente'])): ?>
                <li class="nav-item">
                    <a href="#membrosSubmenuFinanceiro" class="nav-link" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="bi bi-cash"></i>
                        <span>Financeiro</span>
                        <i class="bi bi-chevron-down menu-arrow"></i>
                    </a>
                   
                    <ul class="submenu collapse" id="membrosSubmenuFinanceiro">
                         <!-- Divider -->
                    <hr class="sidebar-divider">
                        <li>
                            <a href="<?= base_url('financeiro/dashboard') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('financeiro/taxas') ?>">
                                <i class="bi bi-list-check"></i> Taxas
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('financeiro/recibos') ?>">
                                <i class="bi bi-receipt"></i> Recibos
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('financeiro/recibos/gerar') ?>">
                                <i class="bi bi-file-earmark-plus"></i> Gerar Recibo
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('financeiro/relatorios') ?>">
                                <i class="bi bi-graph-up"></i> Relatórios
                            </a>
                        </li>
                                           <!-- Divider -->
                       <hr class="sidebar-divider">
                    </ul>
    
                </li>
             
            <?php endif; ?>

            <!-- Carteira Virtual -->
            <li class="nav-item <?php echo ($current_page == 'carteira') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('carteira'); ?>" class="nav-link">
                    <i class="bi bi-credit-card"></i>
                    <span>Carteira Virtual</span>
                </a>
            </li>

            <!-- Calendário -->
            <li class="nav-item <?php echo ($current_page == 'calendario') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('calendario'); ?>" class="nav-link">
                    <i class="bi bi-calendar3"></i>
                    <span>Calendário</span>
                </a>
            </li>

            <!-- Boletins -->
            <li class="nav-item <?php echo ($current_page == 'boletins') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('boletins'); ?>" class="nav-link">
                    <i class="bi bi-newspaper"></i>
                    <span>Boletins</span>
                </a>
            </li>

            <!-- Publicações -->
            <li class="nav-item <?php echo ($current_page == 'publicacoes') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('publicacoes'); ?>" class="nav-link">
                    <i class="bi bi-book"></i>
                    <span>Publicações</span>
                </a>
            </li>

            <!-- Membros -->
            <li class="nav-item">
                <a href="#membrosSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="bi bi-people"></i>
                    <span>Membros</span>
                    <i class="bi bi-chevron-down menu-arrow"></i>
                </a>
                <ul class="submenu collapse" id="membrosSubmenu">
                    <li>
                        <a href="<?php echo base_url('controlador/perfil-membro'); ?>">    <i class="bi bi-people"></i>Perfil do Membro</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('historico_participacao'); ?>">    <i class="bi bi-people"></i>Histórico de Participação</a>
                    </li>
                </ul>
            </li>

            <!-- Cadastros -->
            <?php if ($user_data['role'] == 'admin'): ?>
            <li class="nav-item">
                <a href="#membrosSubmenuCadastro" class="nav-link" data-bs-toggle="collapse" aria-expanded="false">
                <i class="bi bi-person-plus"></i>
                    <span>Cadastro</span>
                    <i class="bi bi-chevron-down menu-arrow"></i>
                </a>
                <ul class="submenu collapse" id="membrosSubmenuCadastro">
                    <li>
                    <a href="<?php echo base_url('form-20'); ?>"><i class="bi bi-folder"></i> Ficha n.20</a>
                    </li>
                    <li><a href="<?php echo base_url('controlador/gerenciar_conteudos_iead'); ?>"><i class="bi bi-file-earmark-text"></i> Gerenciar Conteúdos IEAD</a></li>
                    <li><a href="<?php echo base_url('controlador/planilhas'); ?>"><i
                                class="bi bi-file-earmark-spreadsheet"></i> Gerenciar Planilhas</a></li>
                    <li><a href="<?php echo base_url('controlador/cadastrar_usuario'); ?>"><i
                                class="bi bi-person-plus"></i> Cadastrar Usuário</a></li>
                    <li>
                        <a href="<?php echo base_url('controlador/listar_usuarios'); ?>">
                            <i class="bi bi-people"></i> Listar Usuários
                        </a>
                    </li>
                   
                </ul>
            </li>
            <?php endif; ?>

            <!-- Delegacias -->
            <li class="nav-item <?php echo ($current_page == 'delegacias') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('delegacias'); ?>" class="nav-link">
                    <i class="bi bi-building"></i>
                    <span>Delegacias</span>
                </a>
            </li>

            <!-- Contato -->
            <li class="nav-item <?php echo ($current_page == 'contato') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('contato'); ?>" class="nav-link">
                    <i class="bi bi-envelope"></i>
                    <span>Contato</span>
                </a>
            </li>

            <!-- Divisor -->
            <li class="nav-divider"></li>

            <!-- CLUBE MONTEZUMA -->
            <li class="nav-item <?php echo ($current_page == 'clube') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('clube'); ?>" class="nav-link">
                    <i class="bi bi-star"></i>
                    <span>CLUBE MONTEZUMA</span>
                </a>
            </li>

            <!-- IEAD - Instruções -->
            <li class="nav-item <?php echo ($current_page == 'iead') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('iead'); ?>" class="nav-link">
                    <i class="bi bi-info-circle"></i>
                    <span>IEAD - Instruções</span>
                </a>
            </li>

            <!-- Anuidades -->
            <li class="nav-item <?php echo ($current_page == 'anuidades') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('anuidades'); ?>" class="nav-link">
                    <i class="bi bi-cash"></i>
                    <span>Anuidades</span>
                </a>
            </li>

            <!-- Elevações -->
            <li class="nav-item <?php echo ($current_page == 'elevacoes') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('elevacoes'); ?>" class="nav-link">
                    <i class="bi bi-arrow-up-circle"></i>
                    <span>Elevações</span>
                </a>
            </li>

            <!-- Diploma Digital -->
            <li class="nav-item <?php echo ($current_page == 'diploma') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('diploma'); ?>" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Diploma Digital</span>
                </a>
            </li>

            <!-- Abrir Chamado -->
            <li class="nav-item <?php echo ($current_page == 'chamado') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('chamado'); ?>" class="nav-link">
                    <i class="bi bi-ticket"></i>
                    <span>Abrir Chamado</span>
                </a>
            </li>

           
        </ul>

        
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Header -->
        <header class="main-header">
            <div class="header-left">
                <h1 class="page-title"> <?php echo strtoupper($current_page); ?> </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo strtoupper($current_page); ?></li>
                    </ol>
                </nav>
            </div>

            <div class="header-right">
                <!-- Pesquisa -->
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Pesquisar...">
                </div>

                <!-- Notificações -->
               <!-- Notificações -->
    <div class="header-icon-item dropdown">
        <button class="btn" data-bs-toggle="dropdown" id="notificationsDropdown">
            <i class="bi bi-bell"></i>
            <?php if (isset($nao_lidas) && $nao_lidas > 0): ?>
                <span class="notification-badge"><?= $nao_lidas ?></span>
            <?php endif; ?>
        </button>
        <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropdown">
            <div class="dropdown-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Notificações</h6>
                <?php if (isset($nao_lidas) && $nao_lidas > 0): ?>
                    <a href="<?= site_url('controlador/marcar_todas_como_lidas') ?>" class="text-muted small">Marcar todas como lidas</a>
                <?php endif; ?>
            </div>
            <div class="dropdown-body">
                <?php if (empty($notificacoes)): ?>
                    <div class="text-center py-3 text-muted">Nenhuma notificação</div>
                <?php else: ?>
                    <?php foreach ($notificacoes as $notificacao): ?>
                        <a href="<?= $notificacao['link'] ?>" 
                        class="dropdown-item notification-item <?= $notificacao['lida'] ? 'text-muted' : 'fw-bold' ?>"
                        data-id="<?= $notificacao['id'] ?>">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-2">
                                    <i class="bi bi-<?= $notificacao['icon'] ?> text-<?= $notificacao['color'] ?>"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1"><?= htmlspecialchars($notificacao['titulo']) ?></p>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($notificacao['data_notificacao'])) ?></small>
                                    <?php if (!empty($notificacao['mensagem'])): ?>
                                        <div class="small text-muted mt-1"><?= htmlspecialchars($notificacao['mensagem']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="dropdown-footer">
                <a href="<?= site_url('controlador/gerenciar_notificacoes') ?>" class="d-block text-center">Ver todas as notificações</a>
            </div>
        </div>
    </div>

               <!-- Perfil -->
				<div class="header-icon-item dropdown">
					<button 
						class="btn" 
						data-bs-toggle="dropdown" 
						aria-expanded="false" 
						aria-label="Abrir menu de perfil">
						<img 
							src="<?php echo base_url('assets/images/avatar-img.png'); ?>" 
							alt="Avatar do usuário" 
							class="header-avatar">
					</button>
					<div class="dropdown-menu dropdown-menu-end profile-dropdown">
						<!-- Cabeçalho do menu -->
						<div class="dropdown-header d-flex align-items-center">
							<img 
								src="<?php echo base_url('assets/images/avatar-img.png'); ?>" 
								alt="Avatar do usuário" 
								class="header-avatar">
							<div class="ms-3">
								<h6 class="mb-0">
                               
                                
									<?php echo $user_data['cadastro'];?>
                               
								</h6>
								<small class="text-muted">Grau <?php echo $user_data['ativo_no_grau'];?> </small>
							</div>
						</div>
						<!-- Corpo do menu -->
						<div class="dropdown-body">
							  <a href="<?php echo base_url('perfil-membro'); ?>"
								class="dropdown-item" 
								aria-label="Meu Perfil">
								<i class="bi bi-person"></i> Meu Perfil
							</a>
							<a 
								href="<?php echo base_url('configuracoes'); ?>" 
								class="dropdown-item" 
								aria-label="Configurações">
								<i class="bi bi-gear"></i> Configurações
							</a>
						</div>
						<!-- Rodapé do menu -->
						<div class="dropdown-footer">
							<a 
								href="<?php echo base_url('logout'); ?>" 
								class="dropdown-item text-danger" 
								aria-label="Sair da conta">
								<i class="bi bi-box-arrow-right"></i> Sair
							</a>
						</div>
					</div>
				</div>

            </div>
        </header>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
			const dropdownToggles = document.querySelectorAll('.dropdown-menu');
			
			dropdownToggles.forEach((menu) => {
				menu.addEventListener('click', function (e) {
					e.stopPropagation(); // Evita que cliques dentro do menu fechem o dropdown.
				});
			});
		});

		</script>
        <script>
// Marcar notificação como lida ao clicar
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const notifId = this.getAttribute('data-id');
            if (notifId) {
                fetch('<?= site_url("notificacoes/marcar_lida/") ?>' + notifId);
            }
        });
    });
    
    // Atualizar notificações a cada 1 minuto
    setInterval(() => {
        fetch('<?= site_url("notificacoes/contar_nao_lidas/") ?>')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-badge');
                if (data.count > 0) {
                    if (!badge) {
                        const newBadge = document.createElement('span');
                        newBadge.className = 'notification-badge';
                        newBadge.textContent = data.count;
                        document.querySelector('#notificationsDropdown').appendChild(newBadge);
                    } else {
                        badge.textContent = data.count;
                    }
                } else if (badge) {
                    badge.remove();
                }
            });
    }, 60000);
});
</script>
        <!-- Aqui começa o conteúdo específico de cada página -->

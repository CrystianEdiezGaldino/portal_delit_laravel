<style>
    .nav-divider {
        height: 1px;
        background-color: rgba(117, 117, 117, 0.1);
        margin: 1rem 0;
    }

    .nav-menu {
        padding: 1rem 0;
        overflow-y: auto;
        padding: 10px;
    }

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

    .nav-link i {
        width: 20px;
        text-align: center;
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .submenu {
        padding-left: 0.5rem;
    }

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

    @media (max-width: 768px) {
        .sidebar {
            margin-left: calc(var(--sidebar-width)* -1);
        }
    }

    .user-info {
        margin-top: 10px;
        font-size: 0.9rem;
    }
    .user-info p {
        margin-bottom: 5px;
    }
</style>

<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text">Delit Curitiba</span>
            <span class="brand-mini"></span>
        </a>
        <button type="button" id="sidebarCollapse" class="btn">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>

   

    <ul class="nav-menu">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Tutoriais -->
        @if(auth()->user()->ativo_no_grau == 33)
        <li class="nav-item">
            <a href="{{ route('tutorials') }}" class="nav-link {{ request()->routeIs('tutorials') ? 'active' : '' }}">
                <i class="bi bi-play-circle"></i>
                <span>Tutoriais</span>
            </a>
        </li>
        @endif

        <!-- Financeiro -->
        @if(in_array(auth()->user()->role, ['admin', 'atendente']))
        <li class="nav-item">
            <a href="#financialSubmenu" class="nav-link {{ request()->routeIs('financial.*') ? 'active' : '' }}" data-bs-toggle="collapse" aria-expanded="false">
                <i class="bi bi-cash"></i>
                <span>Financeiro</span>
                <i class="bi bi-chevron-down menu-arrow"></i>
            </a>
            <ul class="submenu collapse {{ request()->routeIs('financial.*') ? 'show' : '' }}" id="financialSubmenu">
                <hr class="sidebar-divider">
                <li><a href="{{ route('financial.dashboard') }}" class="{{ request()->routeIs('financial.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="{{ route('financial.fees') }}" class="{{ request()->routeIs('financial.fees') ? 'active' : '' }}"><i class="bi bi-list-check"></i> Taxas</a></li>
                <li><a href="{{ route('financial.receipts') }}" class="{{ request()->routeIs('financial.receipts') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Recibos</a></li>
                <li><a href="{{ route('financial.receipts.create') }}" class="{{ request()->routeIs('financial.receipts.create') ? 'active' : '' }}"><i class="bi bi-file-earmark-plus"></i> Gerar Recibo</a></li>
                <li><a href="{{ route('financial.reports') }}" class="{{ request()->routeIs('financial.reports') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Relatórios</a></li>
                <hr class="sidebar-divider">
            </ul>
        </li>
        @endif

        <!-- Carteira Virtual -->
        <li class="nav-item">
            <a href="{{ route('virtual.card') }}" class="nav-link {{ request()->routeIs('virtual.card') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i>
                <span>Carteira Virtual</span>
            </a>
        </li>

        <!-- Calendário -->
        <li class="nav-item">
            <a href="{{ route('calendar') }}" class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i>
                <span>Calendário</span>
            </a>
        </li>

        <!-- Boletins -->
        <li class="nav-item">
            <a href="{{ route('bulletins') }}" class="nav-link {{ request()->routeIs('bulletins') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i>
                <span>Boletins</span>
            </a>
        </li>

        <!-- Publicações -->
        <li class="nav-item">
            <a href="{{ route('publications') }}" class="nav-link {{ request()->routeIs('publications') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i>
                <span>Publicações</span>
            </a>
        </li>

        <!-- Membros -->
        <li class="nav-item">
            <a href="#membersSubmenu" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}" data-bs-toggle="collapse" aria-expanded="false">
                <i class="bi bi-people"></i>
                <span>Membros</span>
                <i class="bi bi-chevron-down menu-arrow"></i>
            </a>
            <ul class="submenu collapse {{ request()->routeIs('members.*') ? 'show' : '' }}" id="membersSubmenu">
                <hr class="sidebar-divider">
                <li><a href="{{ route('members') }}" class="{{ request()->routeIs('members') ? 'active' : '' }}"><i class="bi bi-list"></i> Todos</a></li>
                <li><a href="{{ route('members.active') }}" class="{{ request()->routeIs('members.active') ? 'active' : '' }}"><i class="bi bi-person-check"></i> Ativos</a></li>
                <li><a href="{{ route('members.inactive') }}" class="{{ request()->routeIs('members.inactive') ? 'active' : '' }}"><i class="bi bi-person-x"></i> Inativos</a></li>
                <hr class="sidebar-divider">
            </ul>
        </li>

        <!-- Cadastro -->
        <li class="nav-item">
            <a href="{{ route('registration') }}" class="nav-link {{ request()->routeIs('registration') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i>
                <span>Cadastro</span>
            </a>
        </li>

        <!-- Delegacias -->
        <li class="nav-item">
            <a href="{{ route('delegacies') }}" class="nav-link {{ request()->routeIs('delegacies') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Delegacias</span>
            </a>
        </li>

        <!-- Contato -->
        <li class="nav-item">
            <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i>
                <span>Contato</span>
            </a>
        </li>

        <!-- CLUBE MONTEZUMA -->
        <li class="nav-item">
            <a href="{{ route('club') }}" class="nav-link {{ request()->routeIs('club') ? 'active' : '' }}">
                <i class="bi bi-house"></i>
                <span>CLUBE MONTEZUMA</span>
            </a>
        </li>

        <!-- IEAD - Instruções -->
        <li class="nav-item">
            <a href="{{ route('iead.index') }}" class="nav-link {{ request()->routeIs('iead.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>IEAD - Instruções</span>
            </a>
        </li>

        <!-- Anuidades -->
        <li class="nav-item">
            <a href="{{ route('annuities') }}" class="nav-link {{ request()->routeIs('annuities') ? 'active' : '' }}">
                <i class="bi bi-currency-dollar"></i>
                <span>Anuidades</span>
            </a>
        </li>

        <!-- Elevações -->
        <li class="nav-item">
            <a href="{{ route('elevations') }}" class="nav-link {{ request()->routeIs('elevations') ? 'active' : '' }}">
                <i class="bi bi-arrow-up-circle"></i>
                <span>Elevações</span>
            </a>
        </li>

        <!-- Diploma Digital -->
        <li class="nav-item">
            <a href="{{ route('digital.diploma') }}" class="nav-link {{ request()->routeIs('digital.diploma') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Diploma Digital</span>
            </a>
        </li>

        <!-- Abrir Chamado -->
        <li class="nav-item">
            <a href="{{ route('tickets.create') }}" class="nav-link {{ request()->routeIs('tickets.create') ? 'active' : '' }}">
                <i class="bi bi-ticket"></i>
                <span>Abrir Chamado</span>
            </a>
        </li>
    </ul>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const sidebarCollapse = document.getElementById('sidebarCollapse');

        if (sidebar && sidebarCollapse) {
            sidebarCollapse.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
        }
    });
</script>
<style>
/* Existing tooltip styles */
#unitip {
    position: fixed !important;
    left: 0 !important;
    top: 0 !important;
    transform: none !important;
    animation: none !important;
    transition: none !important;
    opacity: 1 !important;
    pointer-events: none !important;
}

#unitip {
    display: none !important;
}

/* New styles and animations */
.container {
    animation: fadeIn 0.5s ease-in;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    margin-top: 20px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.btn {
    transition: all 0.3s ease;
    border-radius: 5px;
    margin: 0 3px;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.alert {
    animation: slideIn 0.5s ease;
    border-radius: 5px;
    margin-bottom: 20px;
}

@keyframes slideIn {
    from { transform: translateX(-100%); }
    to { transform: translateX(0); }
}

.table {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
}

.table thead th {
    background: #343a40;
    color: white;
    border: none;
    padding: 15px;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: #e3e3e3;

}

.badge {
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.1);
}

.form-control {
    border-radius: 5px;
    transition: all 0.3s ease;
}

.form-control:focus {
    box-shadow: 0 0 8px rgba(0,123,255,0.25);
    border-color: #80bdff;
}

.btn-group .btn {
    border-radius: 4px;
    margin: 0 2px;
}

/* Pagination styling */
.pagination {
    justify-content: center;
    margin-top: 20px;
}

.pagination .page-link {
    border-radius: 5px;
    margin: 0 3px;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Custom badge colors for status */
.badge-status-aberto {
    background-color: #ff9800;
    color: #fff;
}

.badge-status-andamento {
    background-color: #2196F3;
    color: #fff;
}

.badge-status-resolvido {
    background-color: #4CAF50;
    color: #fff;
}
</style>
<div class="container">
    <h2><?= (in_array($user_role, ['admin', 'atendente'])) ? 'Todos os Chamados' : 'Meus Chamados' ?></h2>
    
    <!-- Mensagens de feedback -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <!-- Barra de ações e filtros -->
    <div class="row mb-3">
        <div class="col-md-6">
            <a href="<?= base_url('chamado/novo') ?>" class="btn btn-primary mb-2">
                <i class="fas fa-plus"></i> Abrir Novo Chamado
            </a>
            <?php if(in_array($user_role, ['admin', 'atendente'])): ?>
                <a href="<?= base_url('chamado/meus-chamados') ?>" class="btn btn-secondary mb-2">
                    <i class="fas fa-list"></i> Meus Chamados
                </a>
            <?php endif; ?>
        </div>
        
        <div class="col-md-6">
           <form method="get" class="form-inline float-md-right">
                <div class="form-group mr-2 mb-2">
                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">Todos Status</option>
                        <option value="aberto" <?= $this->input->get('status') == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                        <option value="em andamento" <?= $this->input->get('status') == 'em andamento' ? 'selected' : '' ?>>Em Andamento</option>
                        <option value="resolvido" <?= $this->input->get('status') == 'resolvido' ? 'selected' : '' ?>>Resolvido</option>
                    </select>
                </div>
                <div class="form-group mr-2 mb-2">
                    <select name="prioridade" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">Todas Prioridades</option>
                        <option value="alta" <?= $this->input->get('prioridade') == 'alta' ? 'selected' : '' ?>>Alta</option>
                        <option value="média" <?= $this->input->get('prioridade') == 'média' ? 'selected' : '' ?>>Média</option>
                        <option value="baixa" <?= $this->input->get('prioridade') == 'baixa' ? 'selected' : '' ?>>Baixa</option>
                    </select>
                </div>
                <div class="form-group mr-2 mb-2">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar..." 
                               value="<?= html_escape($this->input->get('search')) ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="<?= base_url('chamado') ?>" class="btn btn-light">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Tabela de chamados -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Status</th>
                    <th>Prioridade</th>
                    <th>Data Abertura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($chamados)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">Nenhum chamado encontrado</td>
                    </tr>
                <?php else: ?>
                    <?php 
                    // Obter dados do usuário da sessão
                    $user_ime = $this->session->userdata('ime');
                    $user_role = $this->session->userdata('user_data')['role'] ?? '';
                    
                    foreach($chamados as $chamado): 
                    ?>
                    <tr>
                        <td><?= $chamado['id'] ?></td>
                        <td><?= strlen($chamado['titulo']) > 30 ? substr($chamado['titulo'], 0, 30).'...' : $chamado['titulo'] ?></td>
                        <td>
                            <span class="badge badge-<?= 
                                $chamado['status'] == 'aberto' ? 'warning' : 
                                ($chamado['status'] == 'em andamento' ? 'info' : 'success') 
                            ?>">
                                <?= ucfirst($chamado['status']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?= 
                                $chamado['prioridade'] == 'baixa' ? 'success' : 
                                ($chamado['prioridade'] == 'média' ? 'warning' : 'danger') 
                            ?>">
                                <?= ucfirst($chamado['prioridade']) ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($chamado['data_abertura'])) ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <!-- Visualizar (sempre visível) -->
                                <a href="<?= base_url('chamado/visualizar/'.$chamado['id']) ?>" 
                                   class="btn btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Editar (admin/atendente ou dono do chamado) -->
                                <?php if($user_role == 'admin' || $user_role == 'atendente' || $chamado['usuario_ime'] == $user_ime): ?>
                                    <a href="<?= base_url('chamado/editar/'.$chamado['id']) ?>" 
                                       class="btn btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Atender (apenas para chamados abertos e admin/atendente) -->
                                <?php if(($user_role == 'admin' || $user_role == 'atendente') && $chamado['status'] == 'aberto'): ?>
                                    <a href="<?= base_url('chamado/atender/'.$chamado['id']) ?>" 
                                       class="btn btn-primary" title="Atender">
                                        <i class="fas fa-user-check"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Concluir (apenas para chamados em andamento do atendente ou admin) -->
                                <?php if(($user_role == 'admin' || $chamado['atendente_ime'] == $user_ime) && $chamado['status'] == 'em andamento'): ?>
                                    <a href="<?= base_url('chamado/concluir/'.$chamado['id']) ?>" 
                                       class="btn btn-success" title="Concluir">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if(isset($pagination)): ?>
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $pagination ?>
            </div>
        </div>
    <?php endif; ?>
</div>
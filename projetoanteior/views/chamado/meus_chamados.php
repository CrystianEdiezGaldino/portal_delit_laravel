<div class="container">
    <h2>Meus Chamados</h2>
    
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <a href="<?= base_url('chamado/novo') ?>" class="btn btn-primary mb-3">Abrir Novo Chamado</a>
    <a href="<?= base_url('chamado') ?>" class="btn btn-secondary mb-3">Todos os Chamados</a>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
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
                <?php foreach($chamados as $chamado): ?>
                <tr>
                    <td><?= $chamado['id'] ?></td>
                    <td><?= $chamado['titulo'] ?></td>
                    <td>
                        <span class="badge badge-<?= 
                            $chamado['status'] == 'aberto' ? 'warning' : 
                            ($chamado['status'] == 'em andamento' ? 'info' : 
                            ($chamado['status'] == 'resolvido' ? 'success' : 'secondary')) 
                        ?>">
                            <?= ucfirst($chamado['status']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-<?= 
                            $chamado['prioridade'] == 'baixa' ? 'success' : 
                            ($chamado['prioridade'] == 'média' ? 'warning' : 
                            ($chamado['prioridade'] == 'alta' ? 'danger' : 'dark')) 
                        ?>">
                            <?= ucfirst($chamado['prioridade']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($chamado['data_abertura'])) ?></td>
                    <td>
                        <a href="<?= base_url('chamado/visualizar/'.$chamado['id']) ?>" class="btn btn-sm btn-info">Visualizar</a>
                        <?php if($chamado['status'] == 'aberto'): ?>
                            <?php 
                                // Obter dados do usuário da sessão de forma mais limpa
                                $user_role = $this->session->userdata('user_data')['role'];
                                $user_ime = $this->session->userdata('ime');
                            
                                ?>

                                <!-- Botão Editar -->
                                <?php if( $user_role == 'admin' || $user_role == 'atendente'): ?>
                                    <a href="<?= base_url('chamado/editar/'.$chamado['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                                <?php endif; ?>
                           
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
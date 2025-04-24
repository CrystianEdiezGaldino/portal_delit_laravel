<div class="container">
    <h2>Chamado #<?= $chamado['id'] ?> - <?= $chamado['titulo'] ?></h2>
    
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <span class="badge badge-<?= 
                        $chamado['status'] == 'aberto' ? 'warning' : 
                        ($chamado['status'] == 'em andamento' ? 'info' : 
                        ($chamado['status'] == 'resolvido' ? 'success' : 'secondary')) 
                    ?>">
                        <?= ucfirst($chamado['status']) ?>
                    </span>
                    
                    <span class="badge badge-<?= 
                        $chamado['prioridade'] == 'baixa' ? 'success' : 
                        ($chamado['prioridade'] == 'média' ? 'warning' : 
                        ($chamado['prioridade'] == 'alta' ? 'danger' : 'dark')) 
                    ?> ml-2">
                        <?= ucfirst($chamado['prioridade']) ?>
                    </span>
                </div>
                <div>
                <?php 
                // Obter dados do usuário da sessão de forma mais limpa
                $user_role = $this->session->userdata('user_data')['role'];
                $user_ime = $this->session->userdata('ime');
               
                ?>

                <!-- Botão Editar -->
                <?php if ($user_role == 'admin' || $user_role == 'atendente'): ?>
                    <a href="<?= base_url('chamado/editar/'.$chamado['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                <?php endif; ?>

                <!-- Botão Atender --> 
                <?php if ($chamado['status'] == 'aberto' && ($user_role == 'admin' || $user_role == 'atendente')): ?>

                    <a href="<?= base_url('chamado/atender/'.$chamado['id']) ?>" class="btn btn-sm btn-primary">Atender</a>
                <?php endif; ?>

                <!-- Botão Concluir -->
                <?php if ($chamado['status'] == 'em andamento' && ($user_role == 'admin' || $user_role == 'atendente')): ?>
                    <a href="<?= base_url('chamado/concluir/'.$chamado['id']) ?>" class="btn btn-sm btn-success">Concluir</a>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Aberto por:</strong> <?= $chamado['usuario_ime'] ?></p>
            <p><strong>Data de abertura:</strong> <?= date('d/m/Y H:i', strtotime($chamado['data_abertura'])) ?></p>
            <?php if($chamado['atendente_ime']): ?>
                <p><strong>Atendente:</strong> <?= $chamado['atendente_ime'] ?></p>
            <?php endif; ?>
            <?php if($chamado['data_fechamento']): ?>
                <p><strong>Data de fechamento:</strong> <?= date('d/m/Y H:i', strtotime($chamado['data_fechamento'])) ?></p>
            <?php endif; ?>
            
            <hr>
            <h5>Descrição:</h5>
            <p><?= nl2br($chamado['descricao']) ?></p>
        </div>
    </div>
    
    <a href="<?= base_url('chamado') ?>" class="btn btn-secondary">Voltar</a>
</div>
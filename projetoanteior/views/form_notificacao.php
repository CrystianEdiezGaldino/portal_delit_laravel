<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Criar Nova Notificação</h3>
                </div>
                <div class="card-body">
                    <?php echo form_open('notificacoes/criar'); ?>
                        <div class="form-group">
                            <label for="user_ime">IME do Usuário</label>
                            <input type="text" class="form-control" id="user_ime" name="user_ime" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="mensagem">Mensagem</label>
                            <textarea class="form-control" id="mensagem" name="mensagem" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar Notificação
                            </button>
                            <a href="<?php echo site_url('notificacoes/gerenciar'); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

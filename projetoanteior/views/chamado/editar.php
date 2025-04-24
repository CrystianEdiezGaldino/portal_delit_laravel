<div class="container">
    <h2>Editar Chamado #<?= $chamado['id'] ?></h2>
    
    <?php if(validation_errors()): ?>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
    <?php endif; ?>
    
    <form action="<?= base_url('chamado/editar/'.$chamado['id']) ?>" method="post">
        <input type="hidden" name="id" value="<?= $chamado['id'] ?>">
        
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $chamado['titulo'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="prioridade">Prioridade</label>
            <select class="form-control" id="prioridade" name="prioridade" required>
                <option value="baixa" <?= $chamado['prioridade'] == 'baixa' ? 'selected' : '' ?>>Baixa</option>
                <option value="média" <?= $chamado['prioridade'] == 'média' ? 'selected' : '' ?>>Média</option>
                <option value="alta" <?= $chamado['prioridade'] == 'alta' ? 'selected' : '' ?>>Alta</option>
                <option value="urgente" <?= $chamado['prioridade'] == 'urgente' ? 'selected' : '' ?>>Urgente</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="aberto" <?= $chamado['status'] == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                <option value="em andamento" <?= $chamado['status'] == 'em andamento' ? 'selected' : '' ?>>Em Andamento</option>
                <option value="resolvido" <?= $chamado['status'] == 'resolvido' ? 'selected' : '' ?>>Resolvido</option>
                <option value="fechado" <?= $chamado['status'] == 'fechado' ? 'selected' : '' ?>>Fechado</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="5" required><?= $chamado['descricao'] ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Atualizar Chamado</button>
        <a href="<?= base_url('chamado/visualizar/'.$chamado['id']) ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
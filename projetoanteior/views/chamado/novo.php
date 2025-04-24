<div class="container">
    <h2>Abrir Novo Chamado</h2>
    
    <?php if(validation_errors()): ?>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
    <?php endif; ?>
    
    <form action="<?= base_url('chamado/abrir') ?>" method="post">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        
        <div class="form-group">
            <label for="prioridade">Prioridade</label>
            <select class="form-control" id="prioridade" name="prioridade" required>
                <option value="baixa">Baixa</option>
                <option value="média" selected>Média</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="5" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Abrir Chamado</button>
        <a href="<?= base_url('chamado') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
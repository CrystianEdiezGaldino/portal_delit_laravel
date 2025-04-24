<?php if ($user_data['role'] == "admin"): ?>
    <div class="portal-maconico">
    <h2><?php echo isset($planilha) ? 'Editar Planilha' : 'Adicionar Planilha'; ?></h2>

    <form method="post" action="<?php echo isset($planilha) ? base_url('controlador/editar_planilha/' . $planilha['id']) : base_url('controlador/adicionar_planilha'); ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?php echo isset($planilha) ? $planilha['nome'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Arquivo (.pdf)</label>
            <input type="file" name="arquivo" class="form-control" accept=".pdf" <?php echo !isset($planilha) ? 'required' : ''; ?>>
            <?php if (isset($planilha) && !empty($planilha['caminho'])): ?>
                <small class="text-muted">Arquivo atual: <?php echo basename($planilha['caminho']); ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Grau de Acesso</label>
            <input type="number" name="grau_acesso" class="form-control" value="<?php echo isset($planilha) ? $planilha['grau_acesso'] : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="<?php echo base_url('controlador/planilhas'); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
<?php else: ?>
    <p>Você não tem permissão para acessar esta página.</p>
<?php endif; ?>
</div>
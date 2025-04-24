
<div class="portal-maconico"> 
<?php if ($user_data['role'] == "admin"): ?>
    <a href="<?php echo base_url('controlador/adicionar_planilha'); ?>" class="btn btn-primary btn-default">Adicionar Planilha</a>
<?php endif; ?>
<table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($planilhas as $planilha): ?>
            <tr>
                <td><?php echo $planilha['nome']; ?></td>
                <td>
                    <a href="<?php echo base_url('controlador/visualizar_planilha/' . $planilha['id']); ?>" class="btn btn-info">Visualizar</a>
                    <?php if ($user_data['role'] == "admin"): ?>
                        <a href="<?php echo base_url('controlador/editar_planilha/' . $planilha['id']); ?>" class="btn btn-warning">Editar</a>
                        <a href="<?php echo base_url('controlador/deletar_planilha/' . $planilha['id']); ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar esta planilha?')">Deletar</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
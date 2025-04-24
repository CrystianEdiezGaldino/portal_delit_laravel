<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= isset($taxa) ? 'Editar Taxa' : 'Nova Taxa' ?>
            <small>Formulário de taxa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('financeiro') ?>">Financeiro</a></li>
            <li><a href="<?= base_url('financeiro/taxas') ?>">Taxas</a></li>
            <li class="active"><?= isset($taxa) ? 'Editar' : 'Nova' ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <form action="<?= base_url('financeiro/taxas/salvar') ?>" method="post">
                <?php if(isset($taxa)): ?>
                    <input type="hidden" name="id" value="<?= $taxa->id ?>">
                <?php endif; ?>

                <div class="box-body">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="<?= isset($taxa) ? $taxa->nome : set_value('nome') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= isset($taxa) ? $taxa->descricao : set_value('descricao') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="text" class="form-control money" id="valor" name="valor" 
                               value="<?= isset($taxa) ? number_format($taxa->valor, 2, ',', '.') : set_value('valor') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="">Selecione...</option>
                            <option value="mensal" <?= (isset($taxa) && $taxa->tipo == 'mensal') ? 'selected' : '' ?>>Mensal</option>
                            <option value="anual" <?= (isset($taxa) && $taxa->tipo == 'anual') ? 'selected' : '' ?>>Anual</option>
                            <option value="única" <?= (isset($taxa) && $taxa->tipo == 'única') ? 'selected' : '' ?>>Única</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="ativa" <?= (isset($taxa) && $taxa->status == 'ativa') ? 'selected' : '' ?>>Ativa</option>
                            <option value="inativa" <?= (isset($taxa) && $taxa->status == 'inativa') ? 'selected' : '' ?>>Inativa</option>
                        </select>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="<?= base_url('financeiro/taxas') ?>" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('.money').mask('#.##0,00', {reverse: true});
});
</script> 
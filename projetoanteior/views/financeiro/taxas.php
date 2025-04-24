<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Gerenciamento de Taxas
            <small>Controle de taxas do sistema</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('financeiro') ?>">Financeiro</a></li>
            <li class="active">Taxas</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Taxas</h3>
                <div class="box-tools pull-right">
                    <a href="<?= base_url('financeiro/taxas/nova') ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Nova Taxa
                    </a>
                </div>
            </div>
            
            <div class="box-body">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Nome</th>
                                <th width="20%">Descrição</th>
                                <th width="15%">Valor</th>
                                <th width="10%">Tipo</th>
                                <th width="10%">Status</th>
                                <th width="15%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($taxas) && !empty($taxas)): ?>
                                <?php foreach($taxas as $taxa): ?>
                                    <tr>
                                        <td><?= $taxa->id ?></td>
                                        <td><?= $taxa->nome ?></td>
                                        <td><?= $taxa->descricao ?></td>
                                        <td>R$ <?= number_format($taxa->valor, 2, ',', '.') ?></td>
                                        <td><?= ucfirst($taxa->tipo) ?></td>
                                        <td>
                                            <span class="label label-<?= $taxa->status == 'ativa' ? 'success' : 'danger' ?>">
                                                <?= ucfirst($taxa->status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('financeiro/taxas/editar/'.$taxa->id) ?>" 
                                               class="btn btn-warning btn-xs" 
                                               title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('financeiro/taxas/deletar/'.$taxa->id) ?>" 
                                               class="btn btn-danger btn-xs" 
                                               onclick="return confirm('Tem certeza que deseja excluir esta taxa?')"
                                               title="Excluir">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Nenhuma taxa cadastrada</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div> 
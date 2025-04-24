<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Elevações</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($elevacoes) && !empty($elevacoes)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Grau Anterior</th>
                                        <th>Novo Grau</th>
                                        <th>Loja</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($elevacoes as $elevacao): ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y', strtotime($elevacao['data'])); ?></td>
                                            <td><?php echo $elevacao['grau_anterior']; ?></td>
                                            <td><?php echo $elevacao['novo_grau']; ?></td>
                                            <td><?php echo $elevacao['loja']; ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $elevacao['status'] == 'aprovada' ? 'success' : ($elevacao['status'] == 'pendente' ? 'warning' : 'danger'); ?>">
                                                    <?php echo ucfirst($elevacao['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (!empty($elevacao['certificado'])): ?>
                                                    <a href="<?php echo base_url($elevacao['certificado']); ?>" class="btn btn-primary btn-sm" target="_blank">
                                                        <i class="fas fa-download"></i> Certificado
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Nenhuma elevação registrada no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

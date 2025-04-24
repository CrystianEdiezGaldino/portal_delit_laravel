<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Anuidades</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($anuidades) && !empty($anuidades)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Ano</th>
                                        <th>Valor</th>
                                        <th>Data de Vencimento</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($anuidades as $anuidade): ?>
                                        <tr>
                                            <td><?php echo $anuidade['ano']; ?></td>
                                            <td>R$ <?php echo number_format($anuidade['valor'], 2, ',', '.'); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($anuidade['data_vencimento'])); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $anuidade['status'] == 'pago' ? 'success' : ($anuidade['status'] == 'pendente' ? 'warning' : 'danger'); ?>">
                                                    <?php echo ucfirst($anuidade['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($anuidade['status'] == 'pendente'): ?>
                                                    <a href="<?php echo base_url('controlador/pagar_anuidade/' . $anuidade['id']); ?>" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-credit-card"></i> Pagar
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (!empty($anuidade['comprovante'])): ?>
                                                    <a href="<?php echo base_url($anuidade['comprovante']); ?>" class="btn btn-info btn-sm" target="_blank">
                                                        <i class="fas fa-download"></i> Comprovante
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
                            Nenhuma anuidade registrada no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

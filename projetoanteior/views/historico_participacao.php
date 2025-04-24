<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Histórico de Participação</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($historico) && !empty($historico)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Tipo de Evento</th>
                                        <th>Descrição</th>
                                        <th>Local</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historico as $evento): ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y', strtotime($evento['data'])); ?></td>
                                            <td><?php echo $evento['tipo_evento']; ?></td>
                                            <td><?php echo $evento['descricao']; ?></td>
                                            <td><?php echo $evento['local']; ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $evento['status'] == 'presente' ? 'success' : ($evento['status'] == 'ausente' ? 'danger' : 'warning'); ?>">
                                                    <?php echo ucfirst($evento['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Nenhum histórico de participação registrado no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 
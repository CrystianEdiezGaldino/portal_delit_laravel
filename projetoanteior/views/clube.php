<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Clube Montezuma</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($dados_clube) && !empty($dados_clube)): ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Informações do Membro</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Nome:</strong> <?php echo $dados_clube['nome']; ?></p>
                                                <p class="mb-1"><strong>IME:</strong> <?php echo $dados_clube['ime']; ?></p>
                                                <p class="mb-1"><strong>Data de Adesão:</strong> <?php echo date('d/m/Y', strtotime($dados_clube['data_adesao'])); ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Status:</strong> 
                                                    <span class="badge badge-<?php echo $dados_clube['status'] == 'ativo' ? 'success' : 'danger'; ?>">
                                                        <?php echo ucfirst($dados_clube['status']); ?>
                                                    </span>
                                                </p>
                                                <p class="mb-1"><strong>Pontos:</strong> <?php echo $dados_clube['pontos']; ?></p>
                                                <p class="mb-1"><strong>Nível:</strong> <?php echo $dados_clube['nivel']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Benefícios Disponíveis</h5>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($dados_clube['beneficios'] as $beneficio): ?>
                                                <li class="list-group-item">
                                                    <i class="fas fa-check text-success"></i> <?php echo $beneficio; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Histórico de Pontos</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Descrição</th>
                                                        <th>Pontos</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($dados_clube['historico_pontos'] as $historico): ?>
                                                        <tr>
                                                            <td><?php echo date('d/m/Y', strtotime($historico['data'])); ?></td>
                                                            <td><?php echo $historico['descricao']; ?></td>
                                                            <td><?php echo $historico['pontos']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Dados do Clube Montezuma não disponíveis no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

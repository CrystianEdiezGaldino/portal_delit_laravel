<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Carteira Virtual</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($dados_carteira) && !empty($dados_carteira)): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Dados Pessoais</h5>
                                        <p><strong>Nome:</strong> <?php echo $dados_carteira['nome']; ?></p>
                                        <p><strong>IME:</strong> <?php echo $dados_carteira['ime_num']; ?></p>
                                        <p><strong>Grau:</strong> <?php echo $dados_carteira['ativo_no_grau']; ?></p>
                                        <p><strong>Loja:</strong> <?php echo $dados_carteira['numero_loja']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Status da Carteira</h5>
                                        <p><strong>Status:</strong> <span class="badge bg-success">Ativa</span></p>
                                        <p><strong>Data de Emissão:</strong> <?php echo date('d/m/Y'); ?></p>
                                        <p><strong>Validade:</strong> <?php echo date('d/m/Y', strtotime('+1 year')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">QR Code</h5>
                                        <div class="text-center">
                                            <img src="<?php echo base_url('assets/images/qr-code-placeholder.png'); ?>" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                            <p class="mt-2">Escaneie para validar sua carteira</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            Não foi possível carregar os dados da carteira.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

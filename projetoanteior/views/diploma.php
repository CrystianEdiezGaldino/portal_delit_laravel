<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Diploma Digital</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($diploma) && !empty($diploma)): ?>
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4 class="mb-4">Diploma Maçônico</h4>
                                        <div class="mb-4">
                                            <img src="<?php echo base_url('assets/img/logo-grande.png'); ?>" alt="Logo" class="img-fluid mb-3" style="max-width: 150px;">
                                            <h5><?php echo $diploma['nome']; ?></h5>
                                            <p class="mb-1">IME: <?php echo $diploma['ime']; ?></p>
                                            <p class="mb-1">Grau: <?php echo $diploma['grau']; ?></p>
                                            <p class="mb-1">Loja: <?php echo $diploma['loja']; ?></p>
                                            <p class="mb-1">Data de Iniciação: <?php echo date('d/m/Y', strtotime($diploma['data_iniciacao'])); ?></p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-muted">Este diploma é válido e pode ser verificado através do código QR abaixo:</p>
                                            <img src="<?php echo base_url($diploma['qr_code']); ?>" alt="QR Code" class="img-fluid" style="max-width: 150px;">
                                        </div>
                                        <div class="mt-4">
                                            <a href="<?php echo base_url($diploma['arquivo']); ?>" class="btn btn-primary" target="_blank">
                                                <i class="fas fa-download"></i> Download do Diploma
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Diploma não disponível no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

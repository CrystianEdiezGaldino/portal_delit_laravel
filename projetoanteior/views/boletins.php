<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Boletins</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($boletins) && !empty($boletins)): ?>
                        <div class="row">
                            <?php foreach ($boletins as $boletim): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <?php if (!empty($boletim['imagem'])): ?>
                                            <img src="<?php echo base_url($boletim['imagem']); ?>" class="card-img-top" alt="<?php echo $boletim['titulo']; ?>">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $boletim['titulo']; ?></h5>
                                            <p class="card-text"><?php echo $boletim['descricao']; ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Data: <?php echo date('d/m/Y', strtotime($boletim['data'])); ?></small>
                                                <?php if (!empty($boletim['arquivo'])): ?>
                                                    <a href="<?php echo base_url($boletim['arquivo']); ?>" class="btn btn-primary btn-sm" target="_blank">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Nenhum boletim disponível no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

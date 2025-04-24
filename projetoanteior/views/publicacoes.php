<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Publicações</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($publicacoes) && !empty($publicacoes)): ?>
                        <div class="row">
                            <?php foreach ($publicacoes as $publicacao): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $publicacao['titulo']; ?></h5>
                                            <p class="card-text"><?php echo $publicacao['conteudo']; ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    Data: <?php echo date('d/m/Y', strtotime($publicacao['data'])); ?>
                                                    <?php if (!empty($publicacao['autor'])): ?>
                                                        | Autor: <?php echo $publicacao['autor']; ?>
                                                    <?php endif; ?>
                                                </small>
                                                <?php if (!empty($publicacao['link'])): ?>
                                                    <a href="<?php echo $publicacao['link']; ?>" class="btn btn-primary btn-sm" target="_blank">
                                                        <i class="fas fa-external-link-alt"></i> Ler mais
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
                            Nenhuma publicação disponível no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

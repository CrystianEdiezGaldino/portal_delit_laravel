<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Tutoriais</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if (isset($tutoriais) && !empty($tutoriais)): ?>
                            <?php foreach ($tutoriais as $tutorial): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <?php if (!empty($tutorial['imagem'])): ?>
                                            <img src="<?php echo base_url($tutorial['imagem']); ?>" class="card-img-top" alt="<?php echo $tutorial['titulo']; ?>">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $tutorial['titulo']; ?></h5>
                                            <p class="card-text"><?php echo $tutorial['descricao']; ?></p>
                                            <?php if (!empty($tutorial['link'])): ?>
                                                <a href="<?php echo $tutorial['link']; ?>" class="btn btn-primary" target="_blank">Assistir Tutorial</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-info">
                                    Nenhum tutorial disponível no momento.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

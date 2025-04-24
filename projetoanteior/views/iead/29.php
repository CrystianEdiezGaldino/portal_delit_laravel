<style>
    .card-body {
        padding: 1.5rem;
        background-color: #6d1826;
        color: white;
    }
    .modal {
        --bs-modal-bg: #333333;
    }
    @media (min-width: 992px) {
        .modal-lg, .modal-xl {
            --bs-modal-width: 90%;
        }
    }
    .modal-header {
        border-bottom: var(--bs-modal-header-border-width) solid #dee2e600;
    }
</style>

<div class="mt-12">
    <div class="row">


        <?php if (!empty($conteudos)): ?>
            
            <?php foreach ($conteudos as $conteudo): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if ($conteudo['tipo_conteudo'] == 'video'): ?>
                            <img src="<?php echo base_url('assets/images/thumb.jpg'); ?>" class="card-img-top" alt="Thumbnail do vídeo" data-bs-toggle="modal" data-bs-target="#videoModal<?php echo $conteudo['id']; ?>">
                        <?php else: ?>
                            <img src="<?php echo base_url('assets/images/thumb.jpg'); ?>" class="card-img-top" alt="Thumbnail do conteúdo">
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $conteudo['titulo']; ?></h5>
                            <?php if ($conteudo['tipo_conteudo'] == 'video'): ?>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoModal<?php echo $conteudo['id']; ?>">Assistir</button>
                            <?php elseif ($conteudo['tipo_conteudo'] == 'texto'): ?>
                                <a href="<?php echo base_url($conteudo['caminho_arquivo']); ?>" class="btn btn-primary" target="_blank">Ler Texto</a>
                            <?php elseif ($conteudo['tipo_conteudo'] == 'arquivo'): ?>
                                <a href="<?php echo base_url($conteudo['caminho_arquivo']); ?>" class="btn btn-primary" download>Baixar Arquivo</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Modal para Vídeos -->
                <?php if ($conteudo['tipo_conteudo'] == 'video'): ?>
                    <div class="modal fade" id="videoModal<?php echo $conteudo['id']; ?>" tabindex="-1" aria-labelledby="videoModalLabel<?php echo $conteudo['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="videoModalLabel<?php echo $conteudo['id']; ?>"><?php echo $conteudo['titulo']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <video id="videoPlayer<?php echo $conteudo['id']; ?>" class="w-100" controls>
                                        <source src="<?php echo base_url($conteudo['caminho_arquivo']); ?>" type="video/mp4">
                                        Seu navegador não suporta o vídeo.
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Nenhum conteúdo disponível para este grau.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
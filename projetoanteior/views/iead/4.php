<style>
.card {
    transition: transform 0.3s ease;
    margin-bottom: 20px;
}

.card:hover {
    transform: translateY(-5px);
}

.card-img-top {
    height: 200px;
    object-fit: cover;
    cursor: pointer;
}

.modal-content.bg-dark {
    border: none;
}

.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

.video-container {
    position: relative;
    width: 100%;
    padding-top: 56.25%;
}

.video-player {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>

<?php if (isset($conteudos) && !empty($conteudos)): ?>
    <div id="conteudo" class="container mt-5">
        <div class="row justify-content-center g-3">
            <?php foreach ($conteudos as $conteudo): ?>
                <div class="col-md-4">
                    <div class="card">
                        <?php if ($conteudo['tipo_conteudo'] == 'video'): ?>
                            <img src="<?php echo base_url('assets/images/thumb.jpg'); ?>" 
                                 class="card-img-top" 
                                 alt="Thumbnail do vídeo"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#modal<?php echo $conteudo['id']; ?>">
                        <?php else: ?>
                            <img src="<?php echo base_url($conteudo['caminho_arquivo']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($conteudo['titulo']); ?>"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#modal<?php echo $conteudo['id']; ?>">
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($conteudo['titulo']); ?></h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal<?php echo $conteudo['id']; ?>">
                                <?php echo $conteudo['tipo_conteudo'] == 'video' ? 'Assistir' : 'Ver Conteúdo'; ?>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal para cada conteúdo -->
                <div class="modal fade" id="modal<?php echo $conteudo['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo htmlspecialchars($conteudo['titulo']); ?></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <?php if ($conteudo['tipo_conteudo'] == 'video'): ?>
                                    <div class="video-container">
                                        <video class="video-player" controls controlsList="nodownload" oncontextmenu="return false;">
                                            <source src="<?php echo base_url('controlador/servir_video/'.$conteudo['id']); ?>" type="video/mp4">
                                            Seu navegador não suporta a reprodução de vídeos.
                                        </video>
                                    </div>
                                <?php else: ?>
                                    <img src="<?php echo base_url($conteudo['caminho_arquivo']); ?>" 
                                         class="w-100" 
                                         alt="<?php echo htmlspecialchars($conteudo['titulo']); ?>">
                                <?php endif; ?>
                            </div>
                            <?php if ($conteudo['tipo_conteudo'] != 'video'): ?>
                            <div class="modal-footer">
                                <a href="<?php echo base_url($conteudo['caminho_arquivo']); ?>" class="btn btn-success" download>
                                    <i class="fas fa-download"></i> Baixar Conteúdo
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="container mt-5">
        <div class="text-center">
            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
            <p class="lead">Nenhum conteúdo disponível para este grau.</p>
        </div>
    </div>
<?php endif; ?>

<script>
// Parar o vídeo quando o modal for fechado
document.querySelectorAll('.modal').forEach(function(modal) {
    modal.addEventListener('hidden.bs.modal', function() {
        const video = this.querySelector('video');
        if (video) {
            video.pause();
            video.currentTime = 0;
        }
    });
});

// Prevenir download e menu de contexto dos vídeos
document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('video');
    videos.forEach(function(video) {
        video.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });
        
        video.addEventListener('keydown', function(e) {
            if (e.key === 's' && (e.ctrlKey || e.metaKey)) {
                e.preventDefault();
                return false;
            }
        });
    });
});
</script>
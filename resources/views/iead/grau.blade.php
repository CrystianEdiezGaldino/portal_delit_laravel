<div class="conteudo-container">
    @if(count($conteudos) > 0)
        <div class="conteudo-grid">
            @foreach($conteudos as $conteudo)
                <div class="conteudo-card">
                    @if($conteudo->tipo_conteudo == 'video')
                        <div class="video-container">
                            <div class="youtube-wrapper">
                                @if($conteudo->caminho_arquivo)
                                    <?php
                                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $conteudo->caminho_arquivo, $matches);
                                    $videoId = $matches[1] ?? null;
                                    $embedUrl = "https://www.youtube.com/embed/" . $videoId;
                                    $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                                    ?>
                                    <img src="{{ $thumbnailUrl }}" alt="{{ $conteudo->titulo }}" class="youtube-thumbnail">
                                    <div class="video-overlay">
                                        <button class="btn-visualizar" onclick="abrirVideo('{{ $embedUrl }}', '{{ $conteudo->titulo }}')">
                                            <i class="fas fa-play"></i>
                                            Assistir Vídeo
                                        </button>
                                    </div>
                                    <div class="video-badge">
                                        <i class="fab fa-youtube"></i> YouTube
                                    </div>
                                @else
                                    <div class="video-placeholder">
                                        <i class="fas fa-video"></i>
                                        <p>Nenhum vídeo disponível</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif($conteudo->tipo_conteudo == 'imagem')
                        <div class="imagem-container">
                            <img src="{{ $conteudo->caminho_arquivo }}" alt="{{ $conteudo->titulo }}">
                            <div class="imagem-overlay">
                                <button class="btn-visualizar" onclick="abrirImagem('{{ $conteudo->caminho_arquivo }}', '{{ $conteudo->titulo }}')">
                                    Ampliar
                                </button>
                            </div>
                            <div class="imagem-badge">Imagem</div>
                        </div>
                    @elseif($conteudo->tipo_conteudo == 'pdf')
                        <div class="pdf-container">
                            <div class="pdf-icon">PDF</div>
                            <div class="pdf-overlay">
                                <a href="{{ $conteudo->caminho_arquivo }}" target="_blank" class="btn-visualizar">
                                    Visualizar PDF
                                </a>
                            </div>
                            <div class="pdf-badge">PDF</div>
                        </div>
                    @endif
                    
                    <div class="conteudo-info">
                        <h3 class="conteudo-titulo">{{ $conteudo->titulo }}</h3>
                        <p class="conteudo-descricao">{{ $conteudo->descricao }}</p>
                        <div class="conteudo-meta">
                            <span class="conteudo-data">{{ $conteudo->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            Nenhum conteúdo disponível para este grau.
        </div>
    @endif
</div>

<!-- Modal para visualização de imagem -->
<div id="imagemModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000;">
    <div style="position: relative; width: 90%; max-width: 800px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 id="imagemModalLabel" style="margin: 0;">Visualizar Imagem</h3>
            <button onclick="fecharImagem()" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        <div style="text-align: center;">
            <img id="imagemModalSrc" src="" alt="" style="max-width: 100%; max-height: 70vh;">
        </div>
        <div style="text-align: right; margin-top: 15px;">
            <a href="#" id="downloadImageLink" class="btn-visualizar">Download</a>
            <button onclick="fecharImagem()" class="btn-visualizar" style="margin-left: 10px;">Fechar</button>
        </div>
    </div>
</div>

<!-- Modal para visualização de vídeo -->
<div id="videoModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 1000;">
    <div style="position: relative; width: 90%; max-width: 800px; margin: 50px auto; background: black; padding: 20px; border-radius: 8px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 id="videoModalLabel" style="margin: 0; color: white;">Visualizar Vídeo</h3>
            <button onclick="fecharVideo()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: white;">&times;</button>
        </div>
        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
            <iframe 
                id="videoModalIframe"
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                src=""
                frameborder="0"
                allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
            </iframe>
        </div>
        <div style="text-align: right; margin-top: 15px;">
            <button onclick="fecharVideo()" class="btn-visualizar">Fechar</button>
        </div>
    </div>
</div>

<style>
.conteudo-container {
    padding: 20px 0;
}

.conteudo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    padding: 15px;
}

.conteudo-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    overflow: hidden;
}

.video-container, .imagem-container, .pdf-container {
    position: relative;
    width: 100%;
    height: 200px;
    background: #000;
    border-radius: 8px 8px 0 0;
    overflow: hidden;
}

.video-container {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
}

.youtube-wrapper {
    position: relative;
    width: 100%;
    padding-bottom: 56.25%; /* Proporção 16:9 */
    background: #000;
    cursor: pointer;
}

.youtube-thumbnail {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.5);
    transition: background 0.3s ease;
}

.video-overlay:hover {
    background: rgba(0, 0, 0, 0.7);
}

.video-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #f5f5f5;
    color: #666;
}

.video-placeholder i {
    font-size: 48px;
    margin-bottom: 10px;
}

.video-container video {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.imagem-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.imagem-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.imagem-container:hover .imagem-overlay {
    opacity: 1;
}

.pdf-container {
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pdf-icon {
    font-size: 48px;
    color: #960018;
}

.video-badge, .imagem-badge, .pdf-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.6);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
}

.conteudo-info {
    padding: 18px;
}

.conteudo-titulo {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #960018;
}

.conteudo-descricao {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 15px;
    line-height: 1.5;
}

.conteudo-meta {
    color: #777;
    font-size: 0.8rem;
}

.btn-visualizar {
    padding: 12px 24px;
    background: #e74c3c;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: transform 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-visualizar:hover {
    transform: scale(1.05);
}

.btn-visualizar i {
    margin-right: 5px;
}

@media (max-width: 768px) {
    .conteudo-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
}

video {
    width: 100%;
    max-height: 500px;
}
</style>

<script>
function abrirImagem(src, titulo) {
    document.getElementById('imagemModalSrc').src = src;
    document.getElementById('imagemModalLabel').textContent = titulo || 'Visualizar Imagem';
    document.getElementById('downloadImageLink').href = src;
    document.getElementById('imagemModal').style.display = 'block';
}

function fecharImagem() {
    document.getElementById('imagemModal').style.display = 'none';
}

// Fecha o modal quando clicar fora da imagem
document.getElementById('imagemModal').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharImagem();
    }
});

function abrirVideo(url, titulo) {
    const iframe = document.getElementById('videoModalIframe');
    iframe.src = url;
    document.getElementById('videoModalLabel').textContent = titulo || 'Visualizar Vídeo';
    document.getElementById('videoModal').style.display = 'block';
}

function fecharVideo() {
    const iframe = document.getElementById('videoModalIframe');
    iframe.src = ''; // Limpa o src para parar o vídeo
    document.getElementById('videoModal').style.display = 'none';
}

// Fecha o modal de vídeo quando clicar fora
document.getElementById('videoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharVideo();
    }
});
</script> 
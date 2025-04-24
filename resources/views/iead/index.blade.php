@extends('layouts.app')

@section('content')
<div class="portal-maconico">
    <h1>IEAD - Instruções Escocesas a Distância</h1>

    @php
    $graus = [4, 7, 9, 10, 14, 15, 16, 17, 18, 19, 22, 29, 30, 31, 32, 33];
    @endphp

    <div class="tabs">
        @foreach($graus as $grau)
            @if($grau <= $grau_usuario)
                <button class="tab-button" onclick="carregarConteudo({{ $grau }})">
                    Grau {{ $grau }}
                </button>
            @else
                <button class="tab-button" disabled>
                    Grau {{ $grau }}
                </button>
            @endif
        @endforeach

        @if($is_admin)
            <a href="{{ route('gerenciar.conteudos.iead') }}" class="btn-gerenciar">
                Gerenciar Conteúdos
            </a>
        @endif
    </div>

    <div id="loading" style="display: none;">
        Carregando conteúdo...
    </div>

    <div id="conteudo-container">
        <div class="alert alert-info">
            Selecione um grau para visualizar o conteúdo.
        </div>
    </div>
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
.portal-maconico {
    padding: 20px;
}

h1 {
    color: #960018;
    margin-bottom: 2rem;
    font-size: 2.2rem;
    text-align: center;
}

.tabs {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    justify-content: center;
}

.tab-button {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    background: #700012;
    color: white;
    cursor: pointer;
    min-width: 120px;
    text-align: center;
}

.tab-button:hover {
    background: #960018;
}

.tab-button.active {
    background: #960018;
}

.tab-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

#loading {
    text-align: center;
    padding: 2rem;
    color: #960018;
}

.btn-gerenciar {
    display: inline-block;
    background: #333;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    margin-left: 20px;
}

.btn-gerenciar:hover {
    background: #222;
    color: white;
}

.btn-visualizar {
    padding: 8px 16px;
    background: #960018;
    color: white;
    border-radius: 30px;
    border: none;
    text-decoration: none;
    display: inline-block;
}

.btn-visualizar:hover {
    background: #700012;
    color: white;
}

@media (max-width: 768px) {
    .tabs {
        gap: 0.5rem;
    }
    
    .tab-button {
        min-width: 100px;
        padding: 8px 16px;
    }
}

.video-container {
    position: relative;
    width: 100%;
    height: 200px;
    background: #000;
    overflow: hidden;
}

.youtube-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
    background: #000;
    overflow: hidden;
}

.youtube-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.video-overlay {
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

.youtube-wrapper:hover .video-overlay {
    opacity: 1;
}

.btn-visualizar i {
    margin-right: 5px;
}
</style>

<script>
function carregarConteudo(grau) {
    // Remove classe active de todos os botões
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });

    // Adiciona classe active ao botão clicado
    event.target.classList.add('active');

    // Mostra loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('conteudo-container').innerHTML = '';

    // Faz a requisição
    fetch(`/iead/set-grau?grau=${grau}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao carregar conteúdo');
        }
        return response.text();
    })
    .then(html => {
        document.getElementById('conteudo-container').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('conteudo-container').innerHTML = `
            <div class="alert alert-danger">
                Erro ao carregar o conteúdo. Por favor, tente novamente.
            </div>
        `;
    })
    .finally(() => {
        document.getElementById('loading').style.display = 'none';
    });
}

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
@endsection
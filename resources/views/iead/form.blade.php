@extends('layouts.app')

@section('head')
<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- Dropzone CSS -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        animation: fadeUp 0.5s ease;
    }
    
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
    }
    
    .form-title {
        font-size: 1.8rem;
        color: var(--primary-color, #960018);
        margin-bottom: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .form-title i {
        margin-right: 12px;
        font-size: 1.6rem;
    }
    
    .form-subtitle {
        color: #666;
        font-size: 1rem;
    }
    
    .form-group {
        margin-bottom: 25px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        font-size: 0.95rem;
    }
    
    .form-icon {
        position: absolute;
        left: 12px;
        top: 40px;
        color: #777;
    }
    
    .form-control, .form-select {
        height: 48px;
        padding: 10px 15px 10px 40px;
        border-radius: 8px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color, #960018);
        box-shadow: 0 0 0 3px rgba(150, 0, 24, 0.15);
        outline: none;
    }
    
    textarea.form-control {
        height: auto;
        min-height: 120px;
        resize: vertical;
    }
    
    .form-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn-form {
        flex: 1;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-form i {
        margin-right: 8px;
    }
    
    .btn-primary-custom {
        background: var(--primary-color, #960018);
        color: white;
    }
    
    .btn-primary-custom:hover {
        background: var(--secondary-color, #700012);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(150, 0, 24, 0.3);
    }
    
    .btn-secondary-custom {
        background: #f1f1f1;
        color: #333;
    }
    
    .btn-secondary-custom:hover {
        background: #e0e0e0;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .form-help {
        display: block;
        margin-top: 8px;
        color: #666;
        font-size: 0.85rem;
    }
    
    .file-upload {
        position: relative;
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .file-upload:hover {
        border-color: var(--primary-color, #960018);
    }
    
    .file-upload input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .file-upload-icon {
        font-size: 2.5rem;
        color: #ccc;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .file-upload:hover .file-upload-icon {
        color: var(--primary-color, #960018);
        transform: scale(1.1);
    }
    
    .file-selected {
        border-color: green;
        background-color: rgba(0, 128, 0, 0.05);
    }
    
    .file-selected .file-upload-icon {
        color: green;
    }
    
    .file-selected-message {
        display: none;
        color: green;
        font-weight: 500;
        margin-top: 10px;
    }
    
    .file-selected .file-upload-text {
        display: none;
    }
    
    .file-selected .file-selected-message {
        display: block;
    }
    
    .video-options {
        display: none;
        margin-top: 15px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
    }

    .video-options.active {
        display: block;
    }

    .youtube-preview {
        margin-top: 15px;
        display: none;
    }

    .youtube-preview.active {
        display: block;
    }

    .youtube-preview iframe {
        width: 100%;
        height: 315px;
        border: none;
        border-radius: 8px;
    }
    
    @media (max-width: 768px) {
        .form-container {
            padding: 20px 15px;
        }
        
        .form-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="container">
    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">
                <i class="fas {{ isset($conteudo) ? 'fa-edit' : 'fa-plus-circle' }}"></i>
                {{ isset($conteudo) ? 'Editar' : 'Novo' }} Conteúdo IEAD
            </h2>
            <p class="form-subtitle">
                {{ isset($conteudo) ? 'Atualize as informações do conteúdo conforme necessário.' : 'Preencha todos os campos para adicionar um novo conteúdo.' }}
            </p>
        </div>
        
        <form method="POST" action="{{ isset($conteudo) ? route('editar.conteudo.iead', $conteudo->id) : route('criar.conteudo.iead') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($conteudo))
                @method('POST')
            @endif

            <div class="form-group">
                <label for="titulo" class="form-label">Título</label>
                <i class="fas fa-heading form-icon"></i>
                <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $conteudo->titulo ?? old('titulo') }}" required placeholder="Informe o título do conteúdo">
            </div>

            <div class="form-group">
                <label for="descricao" class="form-label">Descrição</label>
                <i class="fas fa-align-left form-icon" style="top: 48px;"></i>
                <textarea class="form-control" id="descricao" name="descricao" rows="4" required placeholder="Descreva o conteúdo de forma detalhada">{{ $conteudo->descricao ?? old('descricao') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="grau" class="form-label">Grau</label>
                        <i class="fas fa-layer-group form-icon"></i>
                        <select class="form-select" id="grau" name="grau" required>
                            @php
                                $graus = [4, 7, 9, 10, 14, 15, 16, 17, 18, 19, 22, 29, 30, 31, 32, 33];
                            @endphp
                            @foreach($graus as $g)
                                <option value="{{ $g }}" {{ (isset($conteudo) && $conteudo->grau == $g) || old('grau') == $g ? 'selected' : '' }}>
                                    Grau {{ $g }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_conteudo" class="form-label">Tipo de Conteúdo</label>
                        <i class="fas fa-file-alt form-icon"></i>
                        <select class="form-select" id="tipo_conteudo" name="tipo_conteudo" required>
                            <option value="video" {{ (isset($conteudo) && $conteudo->tipo_conteudo == 'video') || old('tipo_conteudo') == 'video' ? 'selected' : '' }}>Vídeo</option>
                            <option value="imagem" {{ (isset($conteudo) && $conteudo->tipo_conteudo == 'imagem') || old('tipo_conteudo') == 'imagem' ? 'selected' : '' }}>Imagem</option>
                            <option value="pdf" {{ (isset($conteudo) && $conteudo->tipo_conteudo == 'pdf') || old('tipo_conteudo') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Campos específicos para vídeo -->
            <div id="camposVideo" style="display: none;">
                <div class="form-group">
                    <label for="video_tipo" class="form-label">Tipo de Vídeo</label>
                    <select class="form-select" id="video_tipo" name="video_tipo">
                        <option value="local" {{ (isset($conteudo) && strpos($conteudo->caminho_arquivo, 'youtube.com/embed') === false) ? 'selected' : '' }}>Vídeo Local</option>
                        <option value="youtube" {{ (isset($conteudo) && strpos($conteudo->caminho_arquivo, 'youtube.com/embed') !== false) ? 'selected' : '' }}>YouTube</option>
                    </select>
                </div>

                <!-- Campos para vídeo local -->
                <div id="videoLocalOptions" style="display: none;">
                    <div class="form-group">
                        <label for="arquivo_video" class="form-label">Arquivo de Vídeo</label>
                        <div class="file-upload" id="fileUploadContainerVideo">
                            <input type="file" class="form-control-file" id="arquivo_video" name="arquivo_video" accept="video/mp4">
                            <div class="file-upload-text">
                                Clique ou arraste o arquivo de vídeo aqui
                                <br>
                                <small class="text-muted">Formato suportado: MP4</small>
                            </div>
                            <div class="file-selected-message">
                                Arquivo selecionado
                            </div>
                        </div>
                        @if(isset($conteudo) && strpos($conteudo->caminho_arquivo, 'youtube.com/embed') === false)
                            <span class="form-help">
                                Arquivo atual: <strong>{{ basename($conteudo->caminho_arquivo) }}</strong>
                                <br>
                                Deixe em branco para manter o arquivo atual.
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Campos para vídeo do YouTube -->
                <div id="videoYoutubeOptions" style="display: none;">
                    <div class="form-group">
                        <label for="youtube_url" class="form-label">URL do YouTube</label>
                        <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                               value="{{ isset($conteudo) && strpos($conteudo->caminho_arquivo, 'youtube.com/embed') !== false ? $conteudo->caminho_arquivo : '' }}"
                               placeholder="Cole aqui o link do vídeo do YouTube">
                    </div>
                    <div class="youtube-preview" id="youtubePreview">
                        <iframe src="" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <!-- Campos para outros tipos de arquivo -->
            <div id="outrosArquivos" style="display: none;">
                <div class="form-group">
                    <label for="arquivo_outros" class="form-label">Arquivo</label>
                    <div class="file-upload" id="fileUploadContainerOutros">
                        <input type="file" class="form-control-file" id="arquivo_outros" name="arquivo_outros">
                        <div class="file-upload-text">
                            Clique ou arraste o arquivo aqui
                            <br>
                            <small class="text-muted">Formatos suportados: JPG, PNG, PDF</small>
                        </div>
                        <div class="file-selected-message">
                            Arquivo selecionado
                        </div>
                    </div>
                    @if(isset($conteudo))
                        <span class="form-help">
                            <i class="fas fa-info-circle"></i> 
                            Arquivo atual: <strong>{{ basename($conteudo->caminho_arquivo) }}</strong>
                            <br>
                            Deixe em branco para manter o arquivo atual.
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-form btn-primary-custom">
                    <i class="fas {{ isset($conteudo) ? 'fa-save' : 'fa-plus-circle' }}"></i>
                    {{ isset($conteudo) ? 'Atualizar' : 'Salvar' }}
                </button>
                <a href="{{ route('gerenciar.conteudos.iead') }}" class="btn-form btn-secondary-custom">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoConteudo = document.getElementById('tipo_conteudo');
        const videoTipo = document.getElementById('video_tipo');
        const camposVideo = document.getElementById('camposVideo');
        const videoLocalOptions = document.getElementById('videoLocalOptions');
        const videoYoutubeOptions = document.getElementById('videoYoutubeOptions');
        const outrosArquivos = document.getElementById('outrosArquivos');
        const youtubeUrl = document.getElementById('youtube_url');
        const youtubePreview = document.getElementById('youtubePreview');
        const arquivoVideo = document.getElementById('arquivo_video');
        const arquivoOutros = document.getElementById('arquivo_outros');

        function atualizarCampos() {
            const tipo = tipoConteudo.value;
            
            // Esconde todos os campos
            camposVideo.style.display = 'none';
            videoLocalOptions.style.display = 'none';
            videoYoutubeOptions.style.display = 'none';
            outrosArquivos.style.display = 'none';

            // Remove required de todos os campos
            if (arquivoVideo) arquivoVideo.removeAttribute('required');
            if (arquivoOutros) arquivoOutros.removeAttribute('required');
            if (youtubeUrl) youtubeUrl.removeAttribute('required');

            if (tipo === 'video') {
                camposVideo.style.display = 'block';
                const videoTipoSelecionado = videoTipo.value;
                
                if (videoTipoSelecionado === 'local') {
                    videoLocalOptions.style.display = 'block';
                    if (arquivoVideo) arquivoVideo.setAttribute('required', 'required');
                } else if (videoTipoSelecionado === 'youtube') {
                    videoYoutubeOptions.style.display = 'block';
                    if (youtubeUrl) youtubeUrl.setAttribute('required', 'required');
                }
            } else {
                outrosArquivos.style.display = 'block';
                if (arquivoOutros) arquivoOutros.setAttribute('required', 'required');
            }
        }

        // Event listeners
        if (tipoConteudo) tipoConteudo.addEventListener('change', atualizarCampos);
        if (videoTipo) videoTipo.addEventListener('change', atualizarCampos);

        // Preview do YouTube
        if (youtubeUrl && youtubePreview) {
            youtubeUrl.addEventListener('input', function() {
                const url = this.value;
                if (url) {
                    const videoId = extrairVideoId(url);
                    if (videoId) {
                        youtubePreview.classList.add('active');
                        const iframe = youtubePreview.querySelector('iframe');
                        if (iframe) {
                            iframe.src = `https://www.youtube.com/embed/${videoId}`;
                        }
                    } else {
                        youtubePreview.classList.remove('active');
                    }
                } else {
                    youtubePreview.classList.remove('active');
                }
            });
        }

        function extrairVideoId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        // Inicializa os campos
        atualizarCampos();
    });
</script>
@endsection 
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ isset($conteudo) ? 'Editar' : 'Novo' }} Conteúdo IEAD</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($conteudo) ? route('editar.conteudo.iead', $conteudo->id) : route('criar.conteudo.iead') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($conteudo))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $conteudo->titulo ?? old('titulo') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $conteudo->descricao ?? old('descricao') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="grau" class="form-label">Grau</label>
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

                        <div class="mb-3">
                            <label for="tipo_conteudo" class="form-label">Tipo de Conteúdo</label>
                            <select class="form-select" id="tipo_conteudo" name="tipo_conteudo" required>
                                <option value="video" {{ (isset($conteudo) && $conteudo->tipo_conteudo == 'video') || old('tipo_conteudo') == 'video' ? 'selected' : '' }}>Vídeo</option>
                                <option value="imagem" {{ (isset($conteudo) && $conteudo->tipo_conteudo == 'imagem') || old('tipo_conteudo') == 'imagem' ? 'selected' : '' }}>Imagem</option>
                                <option value="pdf" {{ (isset($conteudo) && $conteudo->tipo_conteudo == 'pdf') || old('tipo_conteudo') == 'pdf' ? 'selected' : '' }}>PDF</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="arquivo" class="form-label">Arquivo</label>
                            <input type="file" class="form-control" id="arquivo" name="arquivo" {{ !isset($conteudo) ? 'required' : '' }}>
                            @if(isset($conteudo))
                                <small class="text-muted">Deixe em branco para manter o arquivo atual.</small>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($conteudo) ? 'Atualizar' : 'Salvar' }}
                            </button>
                            <a href="{{ route('gerenciar.conteudos.iead') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
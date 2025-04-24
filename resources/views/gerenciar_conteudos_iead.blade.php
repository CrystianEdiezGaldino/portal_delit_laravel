@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Gerenciar Conteúdos IEAD</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('criar.conteudo.iead') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Conteúdo
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Grau</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conteudos as $conteudo)
                    <tr>
                        <td>{{ $conteudo->titulo }}</td>
                        <td>{{ $conteudo->grau }}</td>
                        <td>
                            @switch($conteudo->tipo_conteudo)
                                @case('video')
                                    <i class="fas fa-video"></i> Vídeo
                                    @break
                                @case('imagem')
                                    <i class="fas fa-image"></i> Imagem
                                    @break
                                @case('pdf')
                                    <i class="fas fa-file-pdf"></i> PDF
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <a href="{{ route('editar.conteudo.iead', $conteudo->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('deletar.conteudo.iead', $conteudo->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja deletar este conteúdo?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 
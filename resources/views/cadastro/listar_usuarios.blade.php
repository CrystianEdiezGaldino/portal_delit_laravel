@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Lista de Usuários</h3>
        </div>
        <div class="card-body">
            <!-- Filtros -->
            <form method="GET" action="{{ route('listar.usuarios') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="{{ request('nome') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ime">IME</label>
                            <input type="text" class="form-control" id="ime" name="ime" 
                                   value="{{ request('ime') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="grau">Grau</label>
                            <select class="form-control" id="grau" name="grau">
                                <option value="">Todos</option>
                                @for($i = 1; $i <= 33; $i++)
                                    <option value="{{ $i }}" {{ request('grau') == $i ? 'selected' : '' }}>
                                        {{ $i }}°
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('listar.usuarios') }}" class="btn btn-secondary">Limpar Filtros</a>
                    </div>
                </div>
            </form>

            <!-- Tabela de Usuários -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>IME</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Grau</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->ime }}</td>
                                <td>{{ $usuario->nome }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->grau }}°</td>
                                <td>
                                    <span class="badge {{ $usuario->status == 'ativo' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($usuario->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('editar.usuario', $usuario->ime) }}" 
                                           class="btn btn-sm btn-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmarExclusao('{{ $usuario->ime }}')" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhum usuário encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="d-flex justify-content-center mt-4">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir este usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmarExclusao(ime) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ route('deletar.usuario', '') }}/${ime}`;
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
</script>
@endpush
@endsection 
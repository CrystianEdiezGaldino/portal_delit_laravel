@extends('layouts.app')

@section('head')
<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
@endsection

@section('content')
<style>
    .gerenciar-container {
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #f3f3f3;
        padding-bottom: 15px;
    }
    
    .page-title {
        color: var(--primary-color, #960018);
        font-size: 2rem;
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .page-title i {
        margin-right: 15px;
        font-size: 1.8rem;
    }
    
    .btn-novo {
        background: var(--primary-color, #960018);
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        color: white;
        text-decoration: none;
    }
    
    .btn-novo:hover {
        background: var(--secondary-color, #700012);
        color: white;
    }
    
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        animation: slideDown 0.4s ease-out;
    }
    
    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .table-conteudos {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    
    .table-conteudos thead {
        background-color: var(--primary-color, #960018);
        color: white;
    }
    
    .table-conteudos th {
        padding: 15px;
        font-weight: 500;
        text-align: left;
        border: none;
    }
    
    .table-conteudos td {
        padding: 15px;
        border-top: 1px solid #f3f3f3;
        vertical-align: middle;
    }
    
    .table-conteudos tbody tr {
        transition: all 0.3s ease;
    }
    
    .table-conteudos tbody tr:hover {
        background-color: #f9f9f9;
        transform: translateX(5px);
    }
    
    .tipo-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .tipo-badge.video {
        background-color: #e9f5ff;
        color: #0077cc;
    }
    
    .tipo-badge.imagem {
        background-color: #fff0e1;
        color: #ff8a00;
    }
    
    .tipo-badge.pdf {
        background-color: #ffe8e8;
        color: #ff3333;
    }
    
    .tipo-badge i {
        margin-right: 5px;
        font-size: 1.1em;
    }
    
    .acoes {
        display: flex;
        gap: 10px;
    }
    
    .btn-acao {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: white;
        text-decoration: none;
        cursor: pointer;
    }
    
    .btn-editar {
        background-color: #3498db;
    }
    
    .btn-editar:hover {
        background-color: #2980b9;
        color: white;
    }
    
    .btn-deletar {
        background-color: #e74c3c;
    }
    
    .btn-deletar:hover {
        background-color: #c0392b;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #777;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 20px;
    }
    
    .grau-badge {
        background-color: #f1f1f1;
        color: #333;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .btn-novo {
            margin-top: 15px;
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
    }
</style>

<div class="container">
    <div class="gerenciar-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-graduation-cap fa-fw"></i>
                Gerenciar Conteúdos IEAD
            </h1>
            <a href="{{ route('criar.conteudo.iead') }}" class="btn-novo">
                Novo Conteúdo
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-conteudos">
                <thead>
                    <tr>
                        <th><i class="fas fa-heading me-2"></i> Título</th>
                        <th><i class="fas fa-layer-group me-2"></i> Grau</th>
                        <th><i class="fas fa-file-alt me-2"></i> Tipo</th>
                        <th><i class="fas fa-cogs me-2"></i> Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($conteudos) > 0)
                        @foreach($conteudos as $conteudo)
                            <tr>
                                <td>{{ $conteudo->titulo }}</td>
                                <td><span class="grau-badge">{{ $conteudo->grau }}º</span></td>
                                <td>
                                    @switch($conteudo->tipo_conteudo)
                                        @case('video')
                                            <span class="tipo-badge video">
                                                <i class="fas fa-video"></i> Vídeo
                                            </span>
                                            @break
                                        @case('imagem')
                                            <span class="tipo-badge imagem">
                                                <i class="fas fa-image"></i> Imagem
                                            </span>
                                            @break
                                        @case('pdf')
                                            <span class="tipo-badge pdf">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="acoes">
                                    <a href="{{ route('editar.conteudo.iead', $conteudo->id) }}" class="btn-acao btn-editar" title="Editar">
                                        Editar
                                    </a>
                                    <form action="{{ route('deletar.conteudo.iead', $conteudo->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-acao btn-deletar" title="Excluir" onclick="confirmarExclusao(this)">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="empty-state">
                                <i class="fas fa-folder-open d-block"></i>
                                <p>Nenhum conteúdo cadastrado.</p>
                                <a href="{{ route('criar.conteudo.iead') }}" class="btn-novo mt-3">
                                    Adicionar Conteúdo
                                </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Adiciona animação ao carregar os elementos da tabela
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.table-conteudos tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.animation = `fadeIn 0.3s ease forwards ${0.1 + index * 0.05}s`;
        });
        
        // Confirmação de exclusão usando SweetAlert
        document.querySelectorAll('.btn-deletar').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Esta ação não poderá ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#3498db',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });

    function confirmarExclusao(button) {
        if (confirm('Tem certeza que deseja excluir este conteúdo?')) {
            button.closest('form').submit();
        }
    }
</script>
@endsection 
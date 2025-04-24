<?php if ($user_data['role'] == "admin"): ?>
<style>
    .portal-maconico {
        background-color: var(--bg-light);
        padding: 2rem 0;
        min-height: calc(100vh - var(--header-height));
    }

    .portal-maconico h1 {
        color: var(--primary-color);
        margin-bottom: 2rem;
        font-weight: bold;
        position: relative;
        padding-bottom: 10px;
    }

    .portal-maconico h1::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--primary-color);
        transition: width var(--transition-speed);
    }

    .portal-maconico h1:hover::after {
        width: 100px;
    }

    .btn-criar {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        transition: transform var(--transition-speed), box-shadow var(--transition-speed);
    }

    .btn-criar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(150, 0, 24, 0.2);
        background-color: #7a0014;
        color: white;
    }

    .table {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead {
        background-color: var(--primary-color);
        color: white;
    }

    .table tbody tr {
        transition: background-color var(--transition-speed);
    }

    .table tbody tr:hover {
        background-color: rgba(150, 0, 24, 0.05);
    }

    .btn-acao {
        margin: 0 5px;
        transition: all var(--transition-speed);
    }

    .btn-editar {
        background-color: var(--secondary-color);
        color: white;
        border: none;
    }

    .btn-editar:hover {
        background-color: #454b50;
        transform: scale(1.05);
    }

    .btn-deletar {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-deletar:hover {
        background-color: #bb2d3b;
        transform: scale(1.05);
    }

    /* Estilos do Modal */
    .modal-confirmar {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        opacity: 0;
        transition: opacity var(--transition-speed);
    }

    .modal-confirmar.show {
        opacity: 1;
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.7);
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        transition: transform var(--transition-speed);
        width: 90%;
        max-width: 400px;
    }

    .modal-confirmar.show .modal-content {
        transform: translate(-50%, -50%) scale(1);
    }

    .modal-title {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .modal-buttons {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .btn-confirmar {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        transition: all var(--transition-speed);
    }

    .btn-confirmar:hover {
        background-color: #7a0014;
        transform: translateY(-2px);
    }

    .btn-cancelar {
        background-color: var(--secondary-color);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        transition: all var(--transition-speed);
    }

    .btn-cancelar:hover {
        background-color: #454b50;
        transform: translateY(-2px);
    }
</style>

<div class="portal-maconico">
    <div class="container">
        <h1>Gerenciar Conteúdos IEAD</h1>
        
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <a href="<?php echo base_url('controlador/criar_conteudo_iead'); ?>" class="btn btn-criar mb-3">
            <i class="fas fa-plus-circle me-2"></i>Criar Novo Conteúdo
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Grau</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conteudos as $conteudo): ?>
                <tr>
                    <td><?php echo $conteudo['titulo']; ?></td>
                    <td>Grau <?php echo $conteudo['grau']; ?></td>
                    <td><?php echo ucfirst($conteudo['tipo_conteudo']); ?></td>
                    <td>
                        <a href="<?php echo base_url('controlador/editar_conteudo_iead/' . $conteudo['id']); ?>" 
                           class="btn btn-acao btn-editar">
                           <i class="fas fa-edit me-1"></i>Editar
                        </a>
                        <a href="javascript:void(0);" 
                           class="btn btn-acao btn-deletar" 
                           onclick="confirmarDelecao('<?php echo $conteudo['id']; ?>', '<?php echo htmlspecialchars($conteudo['titulo'], ENT_QUOTES); ?>')">
                           <i class="fas fa-trash-alt me-1"></i>Deletar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Adicione o modal no final do arquivo, antes do endif -->
<div id="modalConfirmar" class="modal-confirmar">
    <div class="modal-content">
        <h3 class="modal-title">Confirmar Exclusão</h3>
        <p>Tem certeza que deseja deletar o conteúdo "<span id="conteudoTitulo"></span>"?</p>
        <p class="text-muted">Esta ação não poderá ser desfeita.</p>
        <div class="modal-buttons">
            <button class="btn-cancelar" onclick="fecharModal()">
                <i class="fas fa-times me-1"></i>Cancelar
            </button>
            <button class="btn-confirmar" id="btnConfirmarDelecao">
                <i class="fas fa-trash-alt me-1"></i>Sim, Deletar
            </button>
        </div>
    </div>
</div>

<script>
function confirmarDelecao(id, titulo) {
    const modal = document.getElementById('modalConfirmar');
    const tituloSpan = document.getElementById('conteudoTitulo');
    const btnConfirmar = document.getElementById('btnConfirmarDelecao');
    
    tituloSpan.textContent = titulo;
    modal.style.display = 'block';
    setTimeout(() => modal.classList.add('show'), 10);
    
    btnConfirmar.onclick = function() {
        window.location.href = '<?php echo base_url('controlador/deletar_conteudo_iead/'); ?>' + id;
    };
}

function fecharModal() {
    const modal = document.getElementById('modalConfirmar');
    modal.classList.remove('show');
    setTimeout(() => modal.style.display = 'none', 300);
}

// Fechar modal ao clicar fora dele
document.getElementById('modalConfirmar').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharModal();
    }
});

// Fechar modal com tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('modalConfirmar').style.display === 'block') {
        fecharModal();
    }
});
</script>
<?php endif; ?>
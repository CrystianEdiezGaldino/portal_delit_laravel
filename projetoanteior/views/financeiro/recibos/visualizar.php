<style>
#unitip {
    position: fixed !important;
    left: 0 !important;
    top: 0 !important;
    transform: none !important;
    animation: none !important;
    transition: none !important;
    opacity: 1 !important;
    pointer-events: none !important;
}

#unitip {
    display: none !important;
}
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Visualizar Recibo #<?= $recibo['id'] ?></h1>
        <div>
            <a href="<?= base_url('financeiro/gerar_pdf_recibo/'.$recibo['id']) ?>" 
               class="btn btn-secondary">
                <i class="fas fa-file-pdf"></i> Gerar PDF
            </a>
            <a href="<?= base_url('financeiro/recibos') ?>" 
               class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detalhes do Recibo</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="font-weight-bold">Status:</label>
                        <span class="badge badge-<?= $recibo['status_pagamento'] == 'confirmado' ? 'success' : 'warning' ?>">
                            <?= ucfirst($recibo['status_pagamento']) ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">IME:</label>
                        <span><?= $recibo['ime'] ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">Nome:</label>
                        <span><?= $recibo['nome_usuario'] ?? 'N/A' ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">Valor Pago:</label>
                        <span>R$ <?= number_format($recibo['valor_pago'], 2, ',', '.') ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">Taxa:</label>
                        <span><?= $recibo['taxa_nome'] ?? 'N/A' ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="font-weight-bold">Data do Pagamento:</label>
                        <span><?= date('d/m/Y H:i', strtotime($recibo['data_pagamento'])) ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">Forma de Pagamento:</label>
                        <span><?= ucfirst($recibo['forma_pagamento']) ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">Meio de Pagamento:</label>
                        <span><?= $recibo['meio_pagamento'] ?></span>
                    </div>
                    <?php if($recibo['numero_transacao']): ?>
                    <div class="mb-3">
                        <label class="font-weight-bold">Número da Transação:</label>
                        <span><?= $recibo['numero_transacao'] ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="font-weight-bold">Recebido por:</label>
                        <span><?= $recibo['recebido_por'] ?></span>
                    </div>
                </div>
            </div>

            <?php if($recibo['descricao']): ?>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="font-weight-bold">Descrição:</label>
                        <p class="mb-0"><?= nl2br($recibo['descricao']) ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if($recibo['data_confirmacao']): ?>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-success mb-0">
                        <i class="fas fa-check-circle"></i> 
                        Pagamento confirmado em <?= date('d/m/Y H:i', strtotime($recibo['data_confirmacao'])) ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($recibo['status_pagamento'] == 'pendente' && 
             in_array($this->session->userdata('user_data')['role'], ['admin', 'atendente'])): ?>
    <div class="card shadow">
        <div class="card-body">
            <form action="<?= base_url('financeiro/confirmar_pagamento/'.$recibo['id']) ?>" method="POST">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Confirmar Pagamento
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    // Adiciona confirmação ao botão de confirmar pagamento
    $('form').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Confirmar Pagamento',
            text: "Deseja confirmar o recebimento deste pagamento?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script> 
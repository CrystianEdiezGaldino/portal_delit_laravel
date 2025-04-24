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
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Recibos</h1>
        <a href="<?= base_url('financeiro/recibos/gerar') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Recibo
        </a>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="<?= base_url('financeiro/recibos') ?>" class="row">
                <div class="col-md-3 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">Todos</option>
                        <option value="pendente" <?= $this->input->get('status') == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="confirmado" <?= $this->input->get('status') == 'confirmado' ? 'selected' : '' ?>>Confirmado</option>
                        <option value="cancelado" <?= $this->input->get('status') == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Data Inicial</label>
                    <input type="date" name="data_inicio" class="form-control" value="<?= $this->input->get('data_inicio') ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Data Final</label>
                    <input type="date" name="data_fim" class="form-control" value="<?= $this->input->get('data_fim') ?>">
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="<?= base_url('financeiro/recibos') ?>" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Limpar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Recibos -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recibos Cadastrados</h6>
        </div>
        <div class="card-body">
            <?php if(empty($recibos)): ?>
                <div class="alert alert-info">
                    Nenhum recibo encontrado.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>IME</th>
                                <th>Nome</th>
                                <th>Taxa</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recibos as $recibo): ?>
                                <tr>
                                    <td><?= $recibo['id'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($recibo['data_pagamento'])) ?></td>
                                    <td><?= $recibo['ime'] ?></td>
                                    <td><?= $recibo['nome_usuario'] ?? 'N/A' ?></td>
                                    <td><?= $recibo['taxa_nome'] ?? 'N/A' ?></td>
                                    <td>R$ <?= number_format($recibo['valor_pago'], 2, ',', '.') ?></td>
                                    <td>
                                        <span class="badge badge-<?= $recibo['status_pagamento'] == 'confirmado' ? 'success' : 
                                            ($recibo['status_pagamento'] == 'pendente' ? 'warning' : 'danger') ?>">
                                            <?= ucfirst($recibo['status_pagamento']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('financeiro/visualizar_recibo/'.$recibo['id']) ?>" 
                                           class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('financeiro/gerar_pdf_recibo/'.$recibo['id']) ?>" 
                                           class="btn btn-sm btn-secondary" title="Gerar PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <?php if($recibo['status_pagamento'] == 'pendente'): ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-success confirmar-pagamento" 
                                                    data-id="<?= $recibo['id'] ?>" 
                                                    title="Confirmar Pagamento">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inicializa DataTables
    $('#dataTable').DataTable({
        "order": [[0, "desc"]], // Ordena por ID decrescente
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
        }
    });

    // Confirmação de pagamento
    $('.confirmar-pagamento').on('click', function() {
        const id = $(this).data('id');
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
                window.location.href = `<?= base_url('financeiro/confirmar_pagamento/') ?>${id}`;
            }
        });
    });
});
</script> 
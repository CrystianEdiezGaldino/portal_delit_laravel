<style>
:root {
    --primary-color: #960018;
    --secondary-color: #54595F;
    --text-color: #7A7A7A;
    --bg-light: #f8f9fa;
    --transition-speed: 0.3s;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --input-focus-shadow: 0 0 0 0.2rem rgba(150, 0, 24, 0.25);
}

/* Enhanced container styling */
.container-fluid {
    padding: 2rem;
    background-color: var(--bg-light);
    min-height: calc(100vh - 60px);
}

/* Enhanced card styling */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    background: white;
    margin-bottom: 2rem;
}

.card-body {
    padding: 2rem;
}

/* Enhanced form controls */
.form-control, .form-select {
    height: 48px;
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: var(--input-focus-shadow);
}

/* Enhanced buttons */
.btn {
    height: 48px;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

/* Enhanced member search result */
#nomeMembro {
    margin-top: 0.75rem;
    padding: 1rem;
    border-radius: 10px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

#nomeMembro.text-success {
    background-color: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
}

#nomeMembro.text-danger {
    background-color: rgba(220, 53, 69, 0.1);
    color: var(--danger-color);
}

/* Enhanced section titles */
.section-title {
    color: var(--primary-color);
    font-size: 1.25rem;
    font-weight: 600;
    margin: 1.5rem 0;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid rgba(150, 0, 24, 0.1);
}

/* Loading animation */
.loading-spinner {
    display: inline-block;
    width: 1.5rem;
    height: 1.5rem;
    border: 3px solid rgba(150, 0, 24, 0.1);
    border-radius: 50%;
    border-top-color: var(--primary-color);
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Gerar Novo Recibo</h1>
            <a href="<?= base_url('financeiro') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="<?= base_url('financeiro/salvar_recibo') ?>" id="formRecibo" class="needs-validation" novalidate>
                    <h5 class="section-title">Dados do Membro</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="ime" class="form-label">IME do Membro *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="ime" name="ime" required>
                                <button class="btn btn-primary" type="button" id="buscarMembro">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div id="nomeMembro" class="small mt-1"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="valor_pago">Valor *</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control money" id="valor_pago" name="valor_pago" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="taxa_id" class="form-label">Taxa</label>
                            <select class="form-control" id="taxa_id" name="taxa_id">
                                <option value="">Selecione uma taxa</option>
                                <?php if(isset($taxas) && is_array($taxas)): ?>
                                    <?php foreach($taxas as $taxa): ?>
                                        <option value="<?= $taxa['id'] ?>" data-valor="<?= $taxa['valor'] ?>">
                                            <?= $taxa['nome'] ?> - R$ <?= number_format($taxa['valor'], 2, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <h5 class="section-title">Dados do Pagamento</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="forma_pagamento" class="form-label">Forma de Pagamento *</label>
                            <select class="form-control" id="forma_pagamento" name="forma_pagamento" required>
                                <option value="">Selecione</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cartão de crédito">Cartão de Crédito</option>
                                <option value="cartão de débito">Cartão de Débito</option>
                                <option value="transferência">Transferência</option>
                                <option value="pix">PIX</option>
                                <option value="boleto">Boleto</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="meio_pagamento" class="form-label">Meio de Pagamento *</label>
                            <input type="text" class="form-control" id="meio_pagamento" name="meio_pagamento" required>
                            <small class="text-muted">Ex: Banco do Brasil, Nubank, etc.</small>
                        </div>

                        <div class="col-md-4">
                            <label for="tipo_recibo" class="form-label">Tipo de Recibo *</label>
                            <select class="form-control" id="tipo_recibo" name="tipo_recibo" required>
                                <option value="">Selecione</option>
                                <option value="mensalidade">Mensalidade</option>
                                <option value="doação">Doação</option>
                                <option value="compra">Compra</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                        </div>
                    </div>

                    <input type="hidden" id="numero_transacao" name="numero_transacao">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Gerar Recibo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Money mask
    $('.money').mask('#.##0,00', {
        reverse: true,
        placeholder: "0,00"
    });

    // Search member
    function buscarMembro(ime) {
        $.ajax({
            url: '<?= base_url('financeiro/buscar_membro') ?>',
            type: 'POST',
            data: {ime: ime},
            dataType: 'json',
            beforeSend: function() {
                $('#nomeMembro').html('<div class="spinner-border spinner-border-sm"></div> Buscando...');
            },
            success: function(response) {
                if(response.success) {
                    $('#nomeMembro').html(`<i class="fas fa-user"></i> ${response.membro.nome}`).addClass('text-success');
                } else {
                    $('#nomeMembro').html('<i class="fas fa-times"></i> Membro não encontrado').addClass('text-danger');
                }
            },
            error: function() {
                $('#nomeMembro').html('<i class="fas fa-exclamation-triangle"></i> Erro ao buscar').addClass('text-danger');
            }
        });
    }

    $('#buscarMembro').click(function() {
        const ime = $('#ime').val().trim();
        if(ime) buscarMembro(ime);
    });

    // Handle form submission
    $('#formRecibo').submit(function(e) {
        e.preventDefault();
        
        const forma = $('#forma_pagamento').val();
        
        // Request transaction number for specific payment methods
        if(['pix', 'transferência', 'cartão de crédito', 'cartão de débito'].includes(forma)) {
            const transacao = prompt('Digite o número da transação:');
            if(!transacao) return false;
            $('#numero_transacao').val(transacao);
        }

        // Submit form
        this.submit();
    });

    // Auto-fill value when selecting a tax
    $('#taxa_id').change(function() {
        const valor = $(this).find(':selected').data('valor');
        if(valor) {
            $('#valor_pago').val(valor.toFixed(2).replace('.', ','));
        }
    });
});
</script>
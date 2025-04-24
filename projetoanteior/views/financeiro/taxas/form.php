<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Nova Taxa</h1>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('financeiro/nova_taxa') ?>" method="POST">
                <div class="form-group">
                    <label for="nome">Nome da Taxa</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input type="text" class="form-control money" id="valor" name="valor" required>
                </div>
                
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select class="form-control" id="tipo" name="tipo" required>
                        <option value="mensal">Mensal</option>
                        <option value="anual">Anual</option>
                        <option value="única">Única</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="<?= base_url('financeiro/taxas') ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.money').mask('#.##0,00', {reverse: true});
});
</script> 
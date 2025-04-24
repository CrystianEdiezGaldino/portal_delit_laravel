
<div class="portal-maconico">
    <div class="container">
        <h2>Confirmar Exclusão de Usuário</h2>
        <p>Você está prestes a deletar o usuário abaixo. Confira os dados antes de prosseguir:</p>
      
        <!-- Exibe os dados do usuário -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Dados do Usuário</h5>
                <p><strong>IME:</strong> <?php echo $usuario['ime']; ?></p>
                <p><strong>Nome:</strong> <?php echo $usuario['nome']; ?></p>
                <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>
                <p><strong>Grau Atual:</strong> <?php echo $pk_usuario['ativo_no_grau']; ?></p>
                <p><strong>Data de Cadastro:</strong> <?php echo $pk_usuario['cadastro']; ?></p>
            </div>
        </div>

        <!-- Formulário de confirmação -->
        <form method="post" action="<?php echo base_url('controlador/deletar_usuario/' . $usuario['ime']); ?>">
            <div class="form-group mt-3">
                <p class="text-danger">Tem certeza que deseja deletar este usuário? Esta ação não pode ser desfeita.</p>
                <button type="submit" name="confirmar" value="1" class="btn btn-danger">Confirmar Exclusão</button>
                <a href="<?php echo base_url('controlador/dashboard'); ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
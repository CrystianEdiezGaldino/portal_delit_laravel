<?php if ($user_data['role'] == "admin"): ?>
    <div class="portal-maconico"> 
        <h2>Cadastrar Usuário</h2>
        <form method="post" action="<?php echo base_url('controlador/salvar_usuario'); ?>">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>IME</label>
                    <input type="text" name="ime" class="form-control" value="<?php echo $proximo_ime_num; ?>" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-default">Próximo</button>
        </form>
    </div>
<?php else: ?>
    <p class="text-danger">Você não tem permissão para acessar esta página.</p>
<?php endif; ?>
<script>
document.querySelector('form').addEventListener('submit', function(event) {
    const ime = document.querySelector('input[name="ime"]').value;
    const email = document.querySelector('input[name="email"]').value;

    if (!ime || !email) {
        alert('Preencha todos os campos obrigatórios.');
        event.preventDefault();
    }

    // Validação básica de email
    if (!email.includes('@')) {
        alert('Email inválido.');
        event.preventDefault();
    }
});
</script>
<?php if ($user_data['role'] == "admin"): ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>Cadastro de Novo Usuário - Passo 1</h3>
            </div>
            <div class="card-body">
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <?php echo form_open('controlador/cadastrar_usuario', ['class' => 'needs-validation']); ?>
                    
                    <div class="form-group mb-3">
                        <label for="ime">IME (CIM) *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="ime" name="ime" 
                                   value="<?php echo set_value('ime'); ?>" 
                                   maxlength="7" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Digite os 6 dígitos do IME (Exemplo: 123.001)</small>
                            <small class="text-info">
                                <i class="fas fa-info-circle"></i> 
                                Último IME cadastrado: <strong><?php echo $ultimo_ime; ?></strong>
                            </small>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nome">Nome Completo *</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="<?php echo set_value('nome'); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo set_value('email'); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="senha">Senha *</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                        <small class="text-muted">Mínimo de 6 caracteres</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="confirma_senha">Confirmar Senha *</label>
                        <input type="password" class="form-control" id="confirma_senha" 
                               name="confirma_senha" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="role">Tipo de Usuário</label>
                        <select class="form-control" id="role" name="role">
                            <option value="usuario">Usuário</option>
                            <option value="atendente">Atendente</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Próximo Passo</button>
                    <a href="<?php echo site_url('controlador/listar_usuarios'); ?>" 
                       class="btn btn-secondary">Cancelar</a>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const imeInput = document.getElementById('ime');
        
        // Formata o IME enquanto digita
        imeInput.addEventListener('input', function(e) {
            // Remove todos os caracteres não numéricos
            let value = this.value.replace(/[^\d]/g, '');
            
            // Limita a 6 dígitos
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            
            // Formata com o ponto (XXX.XXX)
            if (value.length > 3) {
                value = value.slice(0, 3) + '.' + value.slice(3);
            }
            
            this.value = value;
        });
        
        // Validação no envio do formulário
        form.addEventListener('submit', function(event) {
            const ime = imeInput.value.trim();
            
            // Verifica se está vazio
            if (ime === '') {
                event.preventDefault();
                alert('O campo IME é obrigatório!');
                return;
            }
            
            // Verifica o formato correto (XXX.XXX)
            if (!/^\d{3}\.\d{3}$/.test(ime)) {
                event.preventDefault();
                alert('O IME deve estar no formato XXX.XXX (exemplo: 123.001)');
                return;
            }
            
            // Validação da senha
            const senha = document.getElementById('senha').value;
            const confirma = document.getElementById('confirma_senha').value;
            
            if (senha !== confirma) {
                event.preventDefault();
                alert('As senhas não conferem!');
            }
            
            if (senha.length < 6) {
                event.preventDefault();
                alert('A senha deve ter pelo menos 6 caracteres!');
            }
        });
    });
    </script>
<?php else: ?>
    <p class="text-danger">Você não tem permissão para acessar esta página.</p>
<?php endif; ?>
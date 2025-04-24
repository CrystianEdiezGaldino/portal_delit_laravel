
<?php if ($user_data['role'] == "admin"): ?>
    <div class="portal-maconico">
        <div class="container">
            <h2>Listar Usuários</h2>

            <!-- Quantidade de usuários encontrados -->
            <div class="alert alert-info">
                Total de usuários encontrados: <?php echo $total_usuarios; ?>
            </div>
          <!-- Mensagem de sucesso -->
            <div id="alert-message">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close custom-close" data-dismiss="alert" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="progress-bar"></div>
                    </div>
                <?php 
                    // Limpa o flashdata para evitar que apareça novamente
                    $this->session->unset_userdata('success'); 
                endif; ?>
            </div>

            <!-- Script para fechar a mensagem automaticamente -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let alertBox = document.querySelector(".custom-alert");
                    let progressBar = document.querySelector(".progress-bar");

                    if (alertBox) {
                        let closeTimeout = 5000; // Tempo em milissegundos (5 segundos)

                        // Animação da barra de progresso
                        progressBar.style.transition = `width ${closeTimeout}ms linear`;
                        progressBar.style.width = "0%";

                        // Esconde a mensagem após o tempo definido
                        setTimeout(() => {
                            alertBox.style.opacity = "0";
                            setTimeout(() => alertBox.remove(), 500);
                        }, closeTimeout);
                    }
                });
            </script>


            <!-- Formulário de Filtro -->
            <form method="get" action="<?php echo base_url('controlador/listar_usuarios'); ?>" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $this->input->get('nome'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label>IME</label>
                        <input type="text" name="ime" class="form-control" value="<?php echo $this->input->get('ime'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Grau</label>
                        <input type="number" name="grau" class="form-control" value="<?php echo $this->input->get('grau'); ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="<?php echo base_url('controlador/listar_usuarios'); ?>" class="btn btn-secondary">Limpar Filtros</a>
                    </div>
                </div>
            </form>

            <!-- Tabela de Usuários -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>IME</th>
                        <th>Email</th>
                        <th>Grau</th>
                        <th>Role</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario['nome']; ?></td>
                                <td><?php echo $usuario['ime']; ?></td>
                                <td><?php echo $usuario['email']; ?></td>
                                <td><?php echo $usuario['grau']; ?></td>
                                <td><?php echo $usuario['role']; ?></td>
                                <td>
                                    <a href="<?php echo base_url('controlador/editar_usuario/' . $usuario['ime']); ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDeletar<?php echo $usuario['ime']; ?>">Deletar</button>
                                    <!-- Botão para editar senha -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalSenha<?php echo $usuario['ime']; ?>">
                                        Editar Senha
                                    </button>
                                </td>
                            </tr>

                         <!-- Modal de Confirmação de Exclusão -->
                        <div class="modal fade" id="modalDeletar<?php echo $usuario['ime']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalDeletarLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalDeletarLabel">Confirmar Exclusão</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tem certeza que deseja deletar o usuário <strong><?php echo $usuario['nome']; ?></strong> (IME: <?php echo $usuario['ime']; ?>)?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <a href="<?php echo base_url('controlador/deletar_usuario/' . $usuario['ime']); ?>" class="btn btn-danger">Deletar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                          <!-- Modal para editar senha -->
                        <div class="modal fade" id="modalSenha<?php echo $usuario['ime']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalSenhaLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document"> <!-- Centralizado -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalSenhaLabel">Editar Senha</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="<?php echo base_url('controlador/atualizar_senha'); ?>" onsubmit="return validarSenha();">
                                            <input type="hidden" name="ime" value="<?php echo $usuario['ime']; ?>">

                                            <!-- Nova Senha -->
                                            <div class="form-group">
                                                <label for="nova_senha">Nova Senha</label>
                                                <div class="input-group">
                                                    <input type="password" id="nova_senha" name="nova_senha" class="form-control" required oninput="validarCampos()">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleSenha('nova_senha')">👁️</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Confirmar Senha -->
                                            <div class="form-group">
                                                <label for="confirmar_senha">Confirmar Senha</label>
                                                <div class="input-group">
                                                    <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" required oninput="validarCampos()">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleSenha('confirmar_senha')">👁️</button>
                                                    </div>
                                                </div>
                                                <small id="erroSenha" class="text-danger" style="display:none;">As senhas não coincidem!</small>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="submit" id="btnSalvar" class="btn btn-primary" disabled>Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function toggleSenha(id) {
                                let campo = document.getElementById(id);
                                campo.type = campo.type === "password" ? "text" : "password";
                            }

                            function validarCampos() {
                                let novaSenha = document.getElementById('nova_senha').value;
                                let confirmarSenha = document.getElementById('confirmar_senha').value;
                                let btnSalvar = document.getElementById('btnSalvar');
                                let erroSenha = document.getElementById('erroSenha');

                                if (novaSenha && confirmarSenha) {
                                    if (novaSenha === confirmarSenha) {
                                        erroSenha.style.display = "none";
                                        btnSalvar.removeAttribute("disabled");
                                    } else {
                                        erroSenha.style.display = "block";
                                        btnSalvar.setAttribute("disabled", "true");
                                    }
                                } else {
                                    erroSenha.style.display = "none";
                                    btnSalvar.setAttribute("disabled", "true");
                                }
                            }

                            function validarSenha() {
                                let novaSenha = document.getElementById('nova_senha').value;
                                let confirmarSenha = document.getElementById('confirmar_senha').value;

                                if (novaSenha !== confirmarSenha) {
                                    alert("As senhas não coincidem!");
                                    return false;
                                }
                                return true;
                            }
                        </script>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum usuário encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Links de Paginação -->
            <div class="pagination justify-content-center">
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>Você não tem permissão para acessar esta página.</p>
<?php endif; ?>
<!-- Bootstrap JS e Popper.js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> -->
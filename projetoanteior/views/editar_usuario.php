<?php if ($user_data['role'] == "admin"): ?>
    <div class="portal-maconico">
        <div class="container mt-4">
            <h2 class="mb-4">Editar Usuário</h2>
            <form method="post" action="<?php echo base_url('controlador/salvar_edicao_usuario/' . $usuario['id']); ?>">
                <input type="hidden" name="ime_num" value="<?php echo $usuario['ime']; ?>">

                <!-- Seção 1: Dados Básicos -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $usuario['nome']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $usuario['email']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value="admin" <?php echo ($usuario['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?php echo ($usuario['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Grau Atual</label>
                        <input type="number" name="ativo_no_grau" class="form-control" 
                            value="<?php echo $pk_usuario['ativo_no_grau']; ?>" 
                            min="4" max="33">
                    </div>
                </div>

                <hr>

                <!-- Seção 2: Dados Pessoais -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Cadastro</label>
                        <input type="text" name="cadastro" class="form-control" value="<?php echo $pk_usuario['cadastro']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Pai</label>
                        <input type="text" name="pai" class="form-control" value="<?php echo $pk_usuario['pai']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Mãe</label>
                        <input type="text" name="mae" class="form-control" value="<?php echo $pk_usuario['mae']; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Data de Nascimento</label>
                        <input type="date" name="nascimento" class="form-control" value="<?php echo $pk_usuario['nascimento']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Cidade 1</label>
                        <input type="text" name="cidade1" class="form-control" value="<?php echo $pk_usuario['cidade1']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Estado 1</label>
                        <input type="text" name="estado1" class="form-control" value="<?php echo $pk_usuario['estado1']; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Nacionalidade</label>
                        <input type="text" name="nacionalidade" class="form-control" value="<?php echo $pk_usuario['nacionalidade']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Profissão</label>
                        <input type="text" name="profissao" class="form-control" value="<?php echo $pk_usuario['profissao']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Endereço Residencial</label>
                        <input type="text" name="endereco_residencial" class="form-control" value="<?php echo $pk_usuario['endereco_residencial']; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control" value="<?php echo $pk_usuario['bairro']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="<?php echo $pk_usuario['cidade']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Estado</label>
                        <input type="text" name="estado" class="form-control" value="<?php echo $pk_usuario['estado']; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control" value="<?php echo $pk_usuario['cep']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Telefone Residencial</label>
                        <input type="text" name="telefone_residencial" class="form-control" value="<?php echo $pk_usuario['telefone_residencial']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Telefone Comercial</label>
                        <input type="text" name="telefone_comercial" class="form-control" value="<?php echo $pk_usuario['telefone_comercial']; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Celular</label>
                        <input type="text" name="celular" class="form-control" value="<?php echo $pk_usuario['celular']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Estado Civil</label>
                        <select name="estado_civil" class="form-control">
                            <option value="solteiro" <?php echo ($pk_usuario['estado_civil'] == 'solteiro') ? 'selected' : ''; ?>>Solteiro</option>
                            <option value="casado" <?php echo ($pk_usuario['estado_civil'] == 'casado') ? 'selected' : ''; ?>>Casado</option>
                            <option value="divorciado" <?php echo ($pk_usuario['estado_civil'] == 'divorciado') ? 'selected' : ''; ?>>Divorciado</option>
                            <option value="viuvo" <?php echo ($pk_usuario['estado_civil'] == 'viuvo') ? 'selected' : ''; ?>>Viúvo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Número de Filhos</label>
                        <input type="number" name="numero_filhos" class="form-control" value="<?php echo $pk_usuario['numero_filhos']; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Sexo</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" value="M" <?php echo ($pk_usuario['sexo_m'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label">Masculino</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" value="F" <?php echo ($pk_usuario['sexo_f'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label">Feminino</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Esposa</label>
                        <input type="text" name="esposa" class="form-control" value="<?php echo $pk_usuario['esposa']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Nascida</label>
                        <input type="text" name="nascida" class="form-control" value="<?php echo $pk_usuario['nascida']; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Casamento</label>
                        <input type="date" name="casamento" class="form-control" value="<?php echo $pk_usuario['casamento']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>RG</label>
                        <input type="text" name="rg" class="form-control" value="<?php echo $pk_usuario['rg']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Órgão Expedidor</label>
                        <input type="text" name="orgao_expedidor" class="form-control" value="<?php echo $pk_usuario['orgao_expedidor']; ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>CIC</label>
                        <input type="text" name="cic" class="form-control" value="<?php echo $pk_usuario['cic']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Iniciado na Loja</label>
                        <input type="date" name="iniciado_loja" class="form-control" value="<?php echo $pk_usuario['iniciado_loja']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Número da Loja</label>
                        <input type="text" name="numero_loja" class="form-control" value="<?php echo $pk_usuario['numero_loja']; ?>">
                    </div>
                </div>

                <!-- Outras seções do formulário... -->

                <hr>

                <!-- Botão de Salvar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg btn-default">Salvar Alterações</button>
                </div>
            </form>
        </div>   
    </div>
<?php else: ?>
    <p class="alert alert-danger">Você não tem permissão para acessar esta página.</p>
<?php endif; ?>
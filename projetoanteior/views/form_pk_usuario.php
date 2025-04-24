<?php if ($user_data['role'] == "admin"): ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>Cadastro de Usuário - Passo 2 (Dados Complementares)</h3>
            </div>
            <div class="card-body">
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php echo form_open('controlador/cadastrar_pk_usuario/' . $usuario['ime']); ?>
                    <input type="hidden" name="ime_num" value="<?php echo $usuario['ime']; ?>">
                    
                    <!-- Dados Pessoais -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Dados Pessoais</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nome Completo</label>
                                    <input type="text" name="cadastro" class="form-control" 
                                           value="<?php echo isset($usuario['nome']) ? $usuario['nome'] : ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?php echo isset($usuario['email']) ? $usuario['email'] : ''; ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Nome do Pai</label>
                                    <input type="text" name="pai" class="form-control" required 
                                           value="<?php echo set_value('pai', isset($form_data['pai']) ? $form_data['pai'] : ''); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Nome da Mãe</label>
                                    <input type="text" name="mae" class="form-control" required
                                           value="<?php echo set_value('mae', isset($form_data['mae']) ? $form_data['mae'] : ''); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Data de Nascimento</label>
                                    <input type="date" name="nascimento" class="form-control" required
                                           value="<?php echo set_value('nascimento', isset($form_data['nascimento']) ? $form_data['nascimento'] : ''); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Nacionalidade</label>
                                    <input type="text" name="nacionalidade" class="form-control" required
                                           value="<?php echo set_value('nacionalidade', isset($form_data['nacionalidade']) ? $form_data['nacionalidade'] : ''); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Profissão</label>
                                    <input type="text" name="profissao" class="form-control" required
                                           value="<?php echo set_value('profissao', isset($form_data['profissao']) ? $form_data['profissao'] : ''); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>CPF</label>
                                    <input type="text" name="cic" class="form-control" id="cpf" required
                                           value="<?php echo set_value('cic'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentos -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Documentos</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>RG</label>
                                    <input type="text" name="rg" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Órgão Expedidor</label>
                                    <input type="text" name="orgao_expedidor" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Endereço</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Endereço Residencial</label>
                                    <input type="text" name="endereco_residencial" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Bairro</label>
                                    <input type="text" name="bairro" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>CEP</label>
                                    <input type="text" name="cep" class="form-control" id="cep" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Cidade</label>
                                    <input type="text" name="cidade" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Estado</label>
                                    <select name="estado" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contatos -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Contatos</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Telefone Residencial</label>
                                    <input type="text" name="telefone_residencial" class="form-control telefone">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Telefone Comercial</label>
                                    <input type="text" name="telefone_comercial" class="form-control telefone">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Celular</label>
                                    <input type="text" name="celular" class="form-control celular" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dados Familiares -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Dados Familiares</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Estado Civil</label>
                                    <select name="estado_civil" class="form-control" required id="estado_civil">
                                        <option value="">Selecione...</option>
                                        <option value="solteiro" <?php echo set_select('estado_civil', 'solteiro', isset($form_data['estado_civil']) && $form_data['estado_civil'] == 'solteiro'); ?>>Solteiro</option>
                                        <option value="casado" <?php echo set_select('estado_civil', 'casado', isset($form_data['estado_civil']) && $form_data['estado_civil'] == 'casado'); ?>>Casado</option>
                                        <option value="divorciado" <?php echo set_select('estado_civil', 'divorciado', isset($form_data['estado_civil']) && $form_data['estado_civil'] == 'divorciado'); ?>>Divorciado</option>
                                        <option value="viuvo" <?php echo set_select('estado_civil', 'viuvo', isset($form_data['estado_civil']) && $form_data['estado_civil'] == 'viuvo'); ?>>Viúvo</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Número de Filhos</label>
                                    <input type="number" name="numero_filhos" class="form-control" min="0" value="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Sexo</label>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="sexo_m" value="1" class="form-check-input" required>
                                            <label class="form-check-label">Masculino</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="sexo_f" value="1" class="form-check-input">
                                            <label class="form-check-label">Feminino</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos do Cônjuge -->
                            <div id="campos_conjuge" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Nome do Cônjuge</label>
                                        <input type="text" name="esposa" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Nome de Solteira</label>
                                        <input type="text" name="nascida" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Data do Casamento</label>
                                        <input type="date" name="casamento" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dados Maçônicos -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Dados Maçônicos</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Data de Iniciação</label>
                                    <input type="date" name="iniciado_loja" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Número da Loja</label>
                                    <input type="text" name="numero_loja" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Cidade da Loja</label>
                                    <input type="text" name="cidade2" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Estado da Loja</label>
                                    <select name="estado2" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Potência Inicial</label>
                                    <input type="text" name="potencia_inicial" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>CGO Número</label>
                                    <input type="text" name="cgo_num" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Membro Ativo da Loja</label>
                                    <input type="text" name="membro_ativo_loja" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Número da Loja Atual</label>
                                    <input type="text" name="numero_da_loja" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Cidade da Loja Atual</label>
                                    <input type="text" name="cidade3" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Estado da Loja Atual</label>
                                    <select name="estado3" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Potência Corpo Filosófico</label>
                                    <input type="text" name="potencia_corpo_filosofico" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Aprendiz em</label>
                                    <input type="date" name="apr_em" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Companheiro em</label>
                                    <input type="date" name="comp_em" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Mestre em</label>
                                    <input type="date" name="mest_em" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>MI em</label>
                                    <input type="date" name="mi_em" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Grau Atual</label>
                                    <input type="number" name="ativo_no_grau" class="form-control" min="1" max="33" value="1" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Código</label>
                                    <input type="text" name="codigo" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Tipo Categoria</label>
                                    <input type="text" name="tipo_categoria" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Graus e Diplomas -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Graus e Diplomas</h5>
                        </div>
                        <div class="card-body">
                            <!-- Graus 4 até 18 -->
                            <?php 
                            $graus = [4, 5, 7, 9, 10, 14, 15, 16, 18];
                            foreach ($graus as $grau): 
                                $tipo_doc = ($grau == 18) ? 'Breve' : 'Diploma';
                            ?>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Grau <?php echo $grau; ?> em</label>
                                    <input type="date" name="grau_<?php echo $grau; ?>_em" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Col. Corpo <?php echo $grau; ?></label>
                                    <input type="text" name="col_corpo_<?php echo $grau; ?>" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label><?php echo $tipo_doc; ?> <?php echo $grau; ?> Nº</label>
                                    <input type="text" name="<?php echo strtolower($tipo_doc); ?>_<?php echo $grau; ?>_num" class="form-control">
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <!-- Grau 30 (mantido separado pois tem estrutura diferente) -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Grau 30 em</label>
                                    <input type="date" name="grau_30_em" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Col. Corpo 10</label>
                                    <input type="text" name="col_corpo_10" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Patente 30 Nº</label>
                                    <input type="text" name="patente_30_num" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Condecorações e Outros -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Condecorações e Outros Dados</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Condecorações SCB</label>
                                    <input type="text" name="condecoracoes_scb" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>PG Corpo 1</label>
                                    <input type="text" name="pg_corpo_1" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Cond. Rec</label>
                                    <input type="text" name="cond_rec" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Cond. Gr. Rec</label>
                                    <input type="text" name="cond_gr_rec" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Cond. Mont</label>
                                    <input type="text" name="cond_mont" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Ano</label>
                                    <input type="number" name="ano1" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Rec</label>
                                    <input type="text" name="rec" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Gr. Rec</label>
                                    <input type="text" name="gr_rec" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Monte</label>
                                    <input type="text" name="monte" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Finalizar Cadastro</button>
                        <a href="<?php echo site_url('controlador/listar_usuarios'); ?>" 
                           class="btn btn-secondary">Cancelar</a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00');
            $('#cep').mask('00000-000');
            $('.telefone').mask('(00) 0000-0000');
            $('.celular').mask('(00) 00000-0000');

            // Mostrar/ocultar campos do cônjuge baseado no estado civil
            $('#estado_civil').change(function() {
                if ($(this).val() === 'casado') {
                    $('#campos_conjuge').show();
                } else {
                    $('#campos_conjuge').hide();
                }
            });
        });
    </script>
<?php else: ?>
    <p class="text-danger">Você não tem permissão para acessar esta página.</p>
<?php endif; ?>
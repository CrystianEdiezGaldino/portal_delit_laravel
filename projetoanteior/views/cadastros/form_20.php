<div class="portal-maconico">
    <form method="POST" action="<?= base_url('controlador/gerar_pdf') ?>">
        <div class="container-fluid">
            <!-- Campo IME para busca -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <br>
                    <div class="input-group">
                        <input type="text" class="form-control" id="ime_num" name="ime_num" placeholder="Digite o IME para buscar">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" onclick="buscarPorIME()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div id="loading" style="display:none;">Buscando...</div>
                </div>
            </div>

            <!-- Dados Pessoais -->
            <div class="row mb-3">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="id_registro" name="id_registro" placeholder="Registro">
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="cadastro" name="cadastro" placeholder="Nome Completo">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
                </div>
                <div class="col-md-4">
                    <input type="tel" class="form-control" id="celular" name="celular" placeholder="Celular">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF">
                </div>
            </div>

            <!-- Endereço -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <input type="text" class="form-control" id="endereco_residencial" name="endereco_residencial" placeholder="Endereço Residencial">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro">
                </div>
            </div>

            <!-- Dados Adicionais -->
            <?php
            $graus = [4, 7, 9, 10, 14, 15, 16, 17, 18, 19, 22, 29, 30, 31, 32, 33];

            foreach ($graus as $index => $grau) {
                $col_corpo_id = "col_corpo_" . ($grau == 14 ? "4" : ($grau == 15 ? "5" : ($grau >= 16 && $grau <= 18 ? "6" : ($grau == 19 ? "7" : ($grau == 22 ? "8" : ($grau == 29 ? "9" : ($grau == 30 ? "10" : ($grau == 31 ? "11" : ($grau == 32 ? "12" : ($grau == 33 ? "13" : $grau)))))))))); // Ajusta col_corpo conforme seus dados
                $tipo_documento = ($grau >= 30) ? "patente" : ($grau == 18 ? "breve" : "diploma"); // Ajusta para "breve" no grau 18
                $documento_id = "{$tipo_documento}_{$grau}_num";

                // Verifica se há valores nos dados fornecidos
                $grau_value = isset($dados["grau_{$grau}_em"]) ? $dados["grau_{$grau}_em"] : "";
                $col_corpo_value = isset($dados[$col_corpo_id]) ? $dados[$col_corpo_id] : "";
                $documento_value = isset($dados[$documento_id]) ? $dados[$documento_id] : "";

                echo "
                    <div class='row mb-3'>
                        <div class='col-md-4'>
                            <input type='text' class='form-control' id='grau_{$grau}_em' name='grau_{$grau}_em' placeholder='Grau {$grau} (AAAA/MM/DD)' value='{$grau_value}'>
                        </div>
                        <div class='col-md-4'>
                            <input type='text' class='form-control' id='{$col_corpo_id}' name='{$col_corpo_id}' placeholder='Col. Corpo {$grau}' value='{$col_corpo_value}'>
                        </div>
                        <div class='col-md-4'>
                            <input type='text' class='form-control' id='{$documento_id}' name='{$documento_id}' placeholder='" . ucfirst($tipo_documento) . " {$grau}' value='{$documento_value}'>
                        </div>
                    </div>
                ";
            }
            ?>



            <!-- Adicione os demais graus seguindo o mesmo padrão -->

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Gerar PDF</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function buscarPorIME() {
    const ime = document.getElementById('ime_num').value;
    if (!ime) return;

    document.getElementById('loading').style.display = 'block';
    
    fetch(`<?= base_url('controlador/buscar_por_ime/') ?>${ime}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                // Preencher campos
                Object.keys(data).forEach(key => {
                    const element = document.getElementById(key);
                    if (element) element.value = data[key];
                });
            }
            document.getElementById('loading').style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loading').style.display = 'none';
        });
}
</script>
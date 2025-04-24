<style>
    .dados_user{


    display: flex;
    align-content: center;
    justify-content: center;
    align-items: center;
    position: relative;
    }
    .rounded-circle {
    border-radius: 50% !important;
    width: 87%;   
    box-shadow: -4px 0px 14px 1px rgb(0 0 0 / 32%) !important;
}
</style>
<div class="portal-maconico">
    <div class="container py-5">
        <div class="row">
            <!-- Foto de Perfil -->
            <div class="col-md-4 text-center mb-4 mb-md-0 dados_user">
                <img src="<?php echo base_url('assets/images/thumb.jpg'); ?>" alt="Foto de Perfil" class="img-fluid rounded-circle shadow-lg">
            </div>

            <!-- Dados do Usuário -->
            <div class="col-md-8">
                <h3 class="mb-3"><?= $user_data['cadastro'] ?></h3>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <p><strong>Grau:</strong> <?= $user_data['role'] ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>Status da Mensalidade:</strong> <?= $user_data['ativo_no_grau'] == 1 ? 'Em dia' : 'Em atraso' ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <p><strong>Cidade:</strong> <?= $user_data['cidade'] ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>Email:</strong> <?= !empty($user_data['email']) ? $user_data['email'] : 'Não informado' ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <p><strong>Telefone Residencial:</strong> <?= !empty($user_data['telefone_residencial']) ? $user_data['telefone_residencial'] : 'Não informado' ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>Telefone Comercial:</strong> <?= !empty($user_data['telefone_comercial']) ? $user_data['telefone_comercial'] : 'Não informado' ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <p><strong>Celular:</strong> <?= !empty($user_data['celular']) ? $user_data['celular'] : 'Não informado' ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>Estado Civil:</strong> <?= $user_data['estado_civil'] ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <p><strong>Data de Nascimento:</strong> <?= !empty($user_data['nascimento']) ? date('d/m/Y', strtotime($user_data['nascimento'])) : 'Não informado' ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>Nome do Pai:</strong> <?= !empty($user_data['pai']) ? $user_data['pai'] : 'Não informado' ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <p><strong>Nome da Mãe:</strong> <?= !empty($user_data['mae']) ? $user_data['mae'] : 'Não informado' ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>Iniciado na Loja:</strong> <?= !empty($user_data['iniciado_loja']) ? ($user_data['iniciado_loja'] == 1 ? 'Sim' : 'Não') : 'Não informado' ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <p><strong>Status de Atividade no Grau:</strong> <?= $user_data['ativo_no_grau'] == 1 ? 'Ativo' : 'Inativo' ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>IME Número:</strong> <?= !empty($user_data['ime_num']) ? $user_data['ime_num'] : 'Não informado' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

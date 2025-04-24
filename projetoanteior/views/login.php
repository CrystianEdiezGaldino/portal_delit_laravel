<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Maçônico - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/login.css') ?>" rel="stylesheet">
</head>
<style>
.overlay{
    background-image: url(<?= base_url('assets/images/bg_portal.jpg') ?>);
    background-size: cover;
}
.text-center{text-shadow: 1px 1px black;}

</style>

<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Imagem Lateral -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-image">
                <div class="overlay"></div>
                <div class="text-center text-white position-relative">
                    <img src="<?= base_url('assets/images/logo_delit_curitiba.png') ?>" alt="Logo" class="mb-4" style="max-width: 150px;">
                    <h2>Portal DelitCuritiba</h2>
                    <p class="lead">Sabedoria, Força e Beleza</p>
                </div>
            </div>

            <!-- Formulário de Login -->
            <div class="col-md-6 d-flex align-items-center">
           

                <div class="login-form w-100 px-5">
                    <h1 class="mb-4">Bem-vindo ao<br>Portal DelitCuritiba</h1>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" id="errorAlert" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <div class="progress mt-2" style="height: 3px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                        <script>
                            setTimeout(function() {
                                // Remove the alert from DOM
                                var alert = document.getElementById('errorAlert');
                                if(alert) {
                                    alert.style.transition = 'opacity 0.5s';
                                    alert.style.opacity = '0';
                                    setTimeout(function() {
                                        alert.remove();
                                    }, 500);
                                }
                                
                                // Clear session data via AJAX
                                fetch('<?= base_url('controlador/clear_flash_data') ?>', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    }
                                });
                            }, 5000);
                        </script>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" id="successAlert" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <div class="progress mt-2" style="height: 3px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo base_url()?>login" method="post">
                        <div class="mb-4">
                            <label class="form-label">IME (CIM)</label>
                            <input type="text" class="form-control form-control-lg" name="ime" required 
                                   placeholder="Digite seu IME">
                        </div>
          
                        <div class="mb-4">
                            <label class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" name="senha" required 
                                       placeholder="Digite sua senha">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Lembrar-me</label>
                            </div>
                            <a href="#" class="text-decoration-none" data-bs-toggle="modal" 
                               data-bs-target="#forgotPasswordModal">Esqueci minha senha</a>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#firstAccessModal">
                                Primeiro Acesso? Solicite aqui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


   <!-- Modal de Primeiro Acesso -->
    <div class="modal fade" id="firstAccessModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Primeiro Acesso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
             
                    
                    <form action="<?= site_url('controlador/primeiro_acesso') ?>" method="POST" id="firstAccessForm">
                        <div class="mb-3">
                            <label class="form-label">IME (CIM)</label>
                            <input type="text" class="form-control ime-mask" name="ime"  placeholder="000.000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CPF</label>
                            <input type="text" class="form-control cpf-mask" name="cpf" required
                                placeholder="000.000.000-00">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Solicitar Acesso</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Esqueci a Senha -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Recuperação de Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('controlador/recuperar_senha') ?>" method="POST" id="forgotPasswordForm">
                        <div class="mb-3">
                            <label class="form-label">IME (CIM)</label>
                            <input type="text" class="form-control" name="ime" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-mail Cadastrado</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Recuperar Senha</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const senhaInput = document.querySelector('input[name="senha"]');
        const type = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
        senhaInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });
    
    </script>
    <script>
$(document).ready(function(){
    // Aplica máscara de CPF
    $('.cpf-mask').mask('000.000.000-00', {reverse: true});
    $('.ime-mask').mask('000.0000', {reverse: true});
    
   
});
</script>
    <script>
        // Função para gerenciar os alertas
        function handleAlert(alertId, progressBarClass) {
            const alert = document.getElementById(alertId);
            if (alert) {
                const progressBar = alert.querySelector('.progress-bar');
                const duration = 6000; // 6 segundos
                const interval = 10; // Atualiza a cada 10ms
                let timeLeft = duration;

                // Anima a barra de progresso
                const timer = setInterval(() => {
                    timeLeft -= interval;
                    const width = (timeLeft / duration) * 100;
                    progressBar.style.width = width + '%';

                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        $(alert).fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }
                }, interval);
            }
        }

        // Inicializa os timers para os alertas
        document.addEventListener('DOMContentLoaded', function() {
            handleAlert('errorAlert', 'bg-danger');
            handleAlert('successAlert', 'bg-success');
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Delit Curitiba - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .overlay {
            background-image: url('{{ asset('images/bg_portal.jpg') }}');
            background-size: cover;
        }
        .text-center { text-shadow: 1px 1px black; }
        .bg-image {
            position: relative;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .bg-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        .login-form {
            max-width: 400px;
            margin: 0 auto;
        }
        .btn-primary {
            background-color: #8B0000;
            border-color: #8B0000;
        }
        .btn-primary:hover {
            background-color: #660000;
            border-color: #660000;
        }
        .alert {
            position: relative;
            overflow: hidden;
        }
        .alert .progress {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Imagem Lateral -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-image">
                <div class="text-center text-white position-relative">
                    <img src="{{ asset('images/logo_delit_curitiba.png') }}" alt="Logo" class="mb-4" style="max-width: 150px;">
                    <h2>Portal DelitCuritiba</h2>
                    <p class="lead">Sabedoria, Força e Beleza</p>
                </div>
            </div>

            <!-- Formulário de Login -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="login-form w-100 px-5">
                    <h1 class="mb-4">Bem-vindo ao<br>Portal DelitCuritiba</h1>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" id="errorAlert" role="alert">
                            {{ session('error') }}
                            <div class="progress mt-2">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="successAlert" role="alert">
                            {{ session('success') }}
                            <div class="progress mt-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">IME (CIM)</label>
                            <input type="text" class="form-control form-control-lg @error('ime') is-invalid @enderror" 
                                   name="ime" id="ime" value="{{ old('ime') }}" required placeholder="000.000">
                            @error('ime')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
          
                        <div class="mb-4">
                            <label class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg @error('senha') is-invalid @enderror" 
                                       name="senha" required placeholder="Digite sua senha">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('senha')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Lembrar-me</label>
                            </div>
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
                    <form method="POST" action="{{ route('primeiro.acesso') }}" id="firstAccessForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">IME (CIM)</label>
                            <input type="text" class="form-control ime-mask" name="ime" id="modalIme"
                                   placeholder="000.000" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const senhaInput = document.querySelector('input[name="senha"]');
            const type = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
            senhaInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        // Máscaras de input
        $(document).ready(function(){
            // Máscara para CPF
            $('.cpf-mask').mask('000.000.000-00', {reverse: true});
            
            // Máscara para IME
            $('.ime-mask').mask('000.000', {reverse: true});
            
            // Formatar IME antes de enviar o formulário
            $('#firstAccessForm').on('submit', function(e) {
                let ime = $('#modalIme').val();
                // Remove todos os caracteres não numéricos
                ime = ime.replace(/\D/g, '');
                // Formata para o padrão 000.000
                ime = ime.replace(/(\d{3})(\d{3})/, '$1.$2');
                $('#modalIme').val(ime);
            });

            // Formatar IME no formulário principal
            $('form').on('submit', function(e) {
                let ime = $('#ime').val();
                // Remove todos os caracteres não numéricos
                ime = ime.replace(/\D/g, '');
                // Formata para o padrão 000.000
                ime = ime.replace(/(\d{3})(\d{3})/, '$1.$2');
                $('#ime').val(ime);
            });
        });

        // Gerenciamento de alertas
        function handleAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                const progressBar = alert.querySelector('.progress-bar');
                const duration = 6000;
                const interval = 10;
                let timeLeft = duration;

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
            handleAlert('errorAlert');
            handleAlert('successAlert');
        });
    </script>
</body>
</html>
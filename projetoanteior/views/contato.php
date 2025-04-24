<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="portal-maconico">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-envelope-open-text mr-2"></i>Entre em Contato</h3>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert custom-alert success-alert alert-dismissible fade show" role="alert">
                            <div class="alert-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="alert-content">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert custom-alert error-alert alert-dismissible fade show" role="alert">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="alert-content">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="contact-info">
                                <div class="info-header">
                                    <i class="fas fa-address-card info-icon"></i>
                                    <h4>Informações de Contato</h4>
                                </div>
                                
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <h5>Endereço</h5>
                                        <p>
                                            R: Mal. Deodoro, 502 - 7º andar<br>
                                            Sala 710 - Centro<br>
                                            Curitiba - PR<br>
                                            CEP: 80010-010
                                        </p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <i class="fas fa-phone"></i>
                                    <div>
                                        <h5>Telefone</h5>
                                        <p>(41) 3222-5178</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <h5>E-mail</h5>
                                        <p>delitsulpr@gmail.com</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <h5>Horário de Atendimento</h5>
                                        <p>Segunda a Sexta: 9h às 17h</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="contact-form">
                                <div class="form-header">
                                    <i class="fas fa-paper-plane form-icon"></i>
                                    <h4>Envie sua Mensagem</h4>
                                </div>
                                <form action="<?php echo base_url('enviar-mensagem'); ?>" method="post">
                                    <div class="form-group">
                                        <label for="nome"><i class="fas fa-user"></i>Nome</label>
                                        <input type="text" class="form-control custom-input" id="nome" name="nome" 
                                               value="<?php echo $this->session->userdata('user_data')['nome'] ?? ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email"><i class="fas fa-envelope"></i>E-mail</label>
                                        <input type="email" class="form-control custom-input" id="email" name="email" 
                                               value="<?php echo $this->session->userdata('user_data')['email'] ?? ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="assunto"><i class="fas fa-heading"></i>Assunto</label>
                                        <input type="text" class="form-control custom-input" id="assunto" name="assunto" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="mensagem"><i class="fas fa-comment"></i>Mensagem</label>
                                        <textarea class="form-control custom-input" id="mensagem" name="mensagem" rows="5" required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-send">
                                        <i class="fas fa-paper-plane"></i>Enviar Mensagem
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    
    color:  #960018;
    padding: 1.5rem;
    border-bottom: none;
}

.card-header h3 {
    font-size: 1.5rem;
    font-weight: 600;
}

.contact-info {
    background: linear-gradient(145deg, #f8f9fa, #ffffff);
    border-radius: 12px;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.info-header, .form-header {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
}

.info-icon, .form-icon {
    font-size: 2rem;
    color: #960018;
    margin-right: 1rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.info-item:hover {
    transform: translateX(5px);
}

.info-item i {
    color: #960018;
    font-size: 1.5rem;
    margin-right: 1rem;
    margin-top: 0.25rem;
}

.info-item h5 {
    color: #333;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.info-item p {
    color: #666;
    margin-bottom: 0;
    line-height: 1.6;
}

.contact-form {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: flex;
    align-items: center;
    color: #333;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-group label i {
    color: #960018;
    margin-right: 0.5rem;
}

.custom-input {
    border: 2px solid #eee;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.custom-input:focus {
    border-color: #960018;
    box-shadow: 0 0 0 0.2rem rgba(150, 0, 24, 0.1);
}

.btn-send {
    background-color: #960018;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    width: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-send:hover {
    background-color: #7a0014;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(150, 0, 24, 0.2);
}

.alert {
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .contact-info, .contact-form {
        margin-bottom: 1.5rem;
    }
    
    .info-item {
        padding: 0.75rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}.custom-alert {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: none;
    border-radius: 10px;
    margin-bottom: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.5s ease-out;
}

.success-alert {
    background-color: #d4edda;
    border-left: 4px solid #28a745;
    color: #155724;
}

.error-alert {
    background-color: #f8d7da;
    border-left: 4px solid #dc3545;
    color: #721c24;
}

.alert-icon {
    margin-right: 1rem;
    font-size: 1.5rem;
}

.alert-content {
    flex-grow: 1;
    font-weight: 500;
}

.custom-alert .close {
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.custom-alert .close:hover {
    opacity: 1;
}

@keyframes slideIn {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss alerts after 5 minutes (300000 milliseconds)
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert) {
                alert.style.animation = 'fadeOut 0.5s ease-out forwards';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }
        }, 300000);
    });

    // Clear session flash data after alert is dismissed
    const clearFlashData = async () => {
        try {
            await fetch('<?php echo base_url("clear-flash-data"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
        } catch (error) {
            console.error('Error clearing flash data:', error);
        }
    };

    // Add event listener for alert dismissal
    alerts.forEach(alert => {
        alert.addEventListener('closed.bs.alert', clearFlashData);
    });
});
</script>

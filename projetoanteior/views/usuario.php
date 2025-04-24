<?php if(isset($msg) && isset($status) && isset($alert)){
    echo utf8_encode('<script>
        swal({
            title: "'.$alert.'",
            text: "'.$msg.'",
            type: "'.$status.'",
            confirmButtonClass: "btn-success",
            confirmButtonText: "OK!",
            closeOnConfirm: false
        },
        function(){
            window.location = "'.base_url().'cadastrar";
        }); 
    </script>');
} ?>

<div class="bg"></div>
<main class="main">
    <div class="container">
        <div class="top-content">
            <a href="" class="logo logo-big">
                <div class="img-container">
                    <img src="./images/logo-big.png" alt="" />
                </div>
            </a>
        </div>
        <div class="download">
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="#">
                            <div class="breadcrumbs-icon"></div>
                            <span>Inicio</span>
                            <div class="icon-container">
                                <svg width="20px" height="16px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 13l-6-6-6 6" />
                                </svg>
                            </div>
                        </a>
                    </li>
                    <li><span>Perfil do Jogador</span></li>
                </ul>
            </div>
            <div class="download-content">
                <div class="dSystem d-block">
                 
					<div class="text-area">
					<!-- conteudo aqui  -->
					  <div class="profile-header">
						<div class="avatar">
							<img src="<?php echo base_url()?>assets/images/avatar_profile.jpg" alt="Avatar">
						</div>
						<div class="profile-info">
							<h1>GM- WALRKESS</h1>
							<div>
							<!-- Botão VIP -->
                            <span class="badge">
                                VIP
                                <div class="tooltip">
                                    <strong>Benefícios do VIP:</strong>
                                    <ul style="list-style: none; padding: 0; margin: 10px 0;">
                                        <li>🔹 Drop 2x</li>
                                        <li>🔹 Caveiras 2x</li>
                                        <li>🔹 DG Dragon Storm</li>
                                    </ul>
                                </div>
                            </span>
								<span>Até : 10/05/2025</span>
                                <br>
                                <br>
                                <div class="copy-container">
                                    <span>Codigo para convites
                                    <span class="copy-text" id="copyText">102A2245</span></span>
                                    <i class="fas fa-copy copy-icon" id="copyIcon"></i>
                                </div>

                                <div class="message" id="message"></div>

                                <script>
                                    // Obtém o elemento de texto e ícone
                                    var copyText = document.getElementById("copyText");
                                    var copyIcon = document.getElementById("copyIcon");
                                    var message = document.getElementById("message");

                                    // Adiciona o evento de clique no ícone de cópia
                                    copyIcon.addEventListener("click", function() {
                                        // Cria um campo de input temporário
                                        var tempInput = document.createElement("input");
                                        tempInput.value = copyText.textContent; // Define o valor do input como o texto do <span>

                                        // Adiciona o input ao corpo da página
                                        document.body.appendChild(tempInput);

                                        // Seleciona o conteúdo do input
                                        tempInput.select();
                                        tempInput.setSelectionRange(0, 99999); // Para dispositivos móveis

                                        // Copia o conteúdo para a área de transferência
                                        document.execCommand("copy");

                                        // Remove o input temporário da página
                                        document.body.removeChild(tempInput);

                                        // Exibe uma mensagem de sucesso
                                        message.textContent = "Código copiado: " + tempInput.value;
                                        setTimeout(function() {
                                            message.textContent = ""; // Limpa a mensagem após 3 segundos
                                        }, 3000);
                                    });
                                </script>
							</div>
							
						</div>
					</div>

					<!-- Stats -->
					<div class="stats">
						<div class="card">
							<h3>70k</h3>
							<p>Cash</p>
						</div>
						<div class="card">
							<h3>1149</h3>
							<p>Total PVPS</p>
						</div>
						<div class="card">
							<h3>2k</h3>
							<p>Total cash indicação</p>
						</div>
					</div>

                    <div id="tab-container">
                        <div class="tabs">
                            <button class="tab active" onclick="switchTab('dados-gerais', this)">DADOS GERAIS</button>
                            <button class="tab" onclick="switchTab('compra-cash', this)">DOAÇÕES</button>
                            <button class="tab" onclick="switchTab('historico-compra', this)">HISTÓRICO DE DOAÇÕES</button>
                            <button class="tab" onclick="switchTab('indicacoes', this)">CONVITES</button>
                            <button class="tab" onclick="switchTab('penalidades', this)">PENALIDADES</button>
                        </div>

                        <div class="tab-content" id="dados-gerais">
                        <h2>Dados Gerais</h2>
                        <p>Aqui estão as informações gerais do usuário:</p>
                        <br>
                        <table style="width: 100%; border-collapse: collapse;">
                            
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;">Usário</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">GM- WALRKESS</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;">Email</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">joao.silva@email.com</td>
                            </tr>
                           
                           
                        </table>

                        <!-- Botão para trocar senha -->
                        <button class="forum-btn brightness" onclick="togglePasswordForm()" style="margin-top: 20px; padding: 10px;  #007bff; color: white; border: none; cursor: pointer;">Alterar Senha</button>

                        <!-- Formulário oculto para troca de senha -->
                        <div id="password-form" style="display: none; margin-top: 20px;">
                            <h3>Alterar Senha</h3>
                            <form>
                                <label for="current-password">Senha Atual:</label><br>
                                <input type="password" id="current-password" name="current-password" required><br><br>

                                <label for="new-password">Nova Senha:</label><br>
                                <input type="password" id="new-password" name="new-password" required><br><br>

                                <label for="confirm-password">Repetir Nova Senha:</label><br>
                                <input type="password" id="confirm-password" name="confirm-password" required><br><br>

                                <input type="submit" value="Alterar Senha" style="padding: 10px 20px;  #28a745; color: white; border: none;">
                            </form>
                        </div>
                    </div>

                    <script>
                        function togglePasswordForm() {
                            var form = document.getElementById('password-form');
                            if (form.style.display === 'none') {
                                form.style.display = 'block';
                            } else {
                                form.style.display = 'none';
                            }
                        }
                    </script>

                            <div class="tab-content" id="compra-cash">
                                <h2>Doação</h2>
                                <p>Aqui você pode doar para projeto:</p>
                                
                                <div class="cash-cards">
                                    <!-- Card 1k -->
                                    <div class="cash-card">
                                        <h3>1.000K</h3>
                                        <p class="ref_coin_1"></p>
                                        <button  class="forum-btn brightness" onclick="DoarCash(1000)">Doar</button>
                                    </div>
                                    
                                    <!-- Card 5k -->
                                    <div class="cash-card">
                                        <h3>5.000K</h3>
                                        <p class="ref_coin_1"></p>
                                        <button class="forum-btn brightness" onclick="DoarCash(5000)">Doar</button>
                                    </div>

                                    <!-- Card 10k -->
                                    <div class="cash-card">
                                        <h3>10.000K</h3>
                                        <p class="ref_coin_1"></p>
                                        <button class="forum-btn brightness" onclick="DoarCash(10000)">Doar</button>
                                    </div>

                                    <!-- Card 20k -->
                                    <div class="cash-card">
                                        <h3>20.000K</h3>
                                        <p class="ref_coin_2"></p>
                                        <button class="forum-btn brightness" onclick="DoarCash(20000)">Doar</button>
                                    </div>

                                    <!-- Card 50k -->
                                    <div class="cash-card">
                                        <h3>50.000K</h3>
                                        <p>Bônus +5k</p>
                                        <p class="ref_coin_2"></p>
                                        <button class="forum-btn brightness"  onclick="DoarCash(50000)">Doar</button>
                                    </div>

                                     <!-- Card 100k -->
                                     <div class="cash-card">
                                        <h3>100.000K</h3>
                                        <p>Bônus +10k</p>
                                        <p class="ref_coin_2"></p>
                                        <button class="forum-btn brightness"  onclick="DoarCash(50000)">Doar</button>
                                    </div>

                                     <!-- Card 300k -->
                                     <div class="cash-card">
                                        <h3>300.000K</h3>
                                        <p>Bônus +30k + VIP 30 dias</p>
                                        <p class="ref_coin_3"></p>
                                        <button class="forum-btn brightness"  onclick="DoarCash(50000)">Doar</button>
                                    </div>

                                     <!-- Card 400k -->
                                     <div class="cash-card">
                                        <h3>400.000K</h3>
                                        <p>Bônus +40k + VIP 30 dias</p>
                                        <p class="ref_coin_3"></p>
                                        <button class="forum-btn brightness"  onclick="DoarCash(50000)">Doar</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Script de compra -->
                            <script>
                                function DoarCash(valor) {
                                    alert("Você comprou " + valor + " Cash. Pagamento realizado.");
                                }
                            </script>

                        <div class="tab-content" id="historico-compra" style="display: none;">
                            <h2>Histórico de Compra</h2>
                            <p>Confira o histórico completo de todas as compras realizadas:</p>
                            <br>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Data</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Valor</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Descrição</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">01/12/2024</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">100k</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Doação</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">10/12/2024</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">50k</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Doação</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">15/12/2024</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">5k</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Doação</td>
                                </tr>
                            </table>
                        </div>


                        <div class="tab-content" id="indicacoes" style="display: none;">
                                <h2>Convites</h2>
                                <p>Veja os convites realizadas por você:</p>
                                <br>
                                <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Indicado</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Data da Indicação</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Status</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Maria Oliveira</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">05/12/2024</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Ativo</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Carlos Souza</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">12/12/2024</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Ativo</td>
                                </tr>
                                </table>
                            </div>

                            <div class="tab-content" id="penalidades" style="display: none;">
                                <h2>Penalidades</h2>
                                <p>Confira as penalidades aplicadas:</p>
                                <br>
                                <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Tipo</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Motivo</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Data</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Suspensão de acesso</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Uso indevido de recursos</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">15/12/2024</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Bloqueio de conta</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">Inatividade prolongada</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">20/12/2024</td>
                                </tr>
                                </table>
                            </div>
                        </div>

                        <script>
                        // Função para mudar entre as abas
                        function switchTab(tabId, button) {
                            // Esconde todas as abas
                            const tabs = document.querySelectorAll('.tab-content');
                            tabs.forEach(tab => tab.style.display = 'none');
                            
                            // Mostra a aba selecionada
                            document.getElementById(tabId).style.display = 'block';
                            
                            // Remove a classe 'active' de todos os botões
                            const buttons = document.querySelectorAll('.tabs .tab');
                            buttons.forEach(btn => btn.classList.remove('active'));
                            
                            // Adiciona a classe 'active' ao botão clicado
                            button.classList.add('active');
                        }

                        // Inicia a aba "DADOS GERAIS" como ativa
                        document.getElementById('dados-gerais').style.display = 'block';
                        </script>

                </div>
            </div>
        </div>
    </div>
    <div class="main-shadow"></div>
</main>
<style>
		/* Estilo do badge */
		.badge {
			display: inline-block;
			background-color: #ffd700;
			color: #000;
			padding: 5px 10px;
			border-radius: 12px;
			font-weight: bold;
			cursor: pointer;
			position: relative;
			transition: background-color 0.3s ease, color 0.3s ease;
		}

		/* Hover no badge */
		.badge:hover {
			background-color: #ffcc00;
			color: #fff;
		}

		/* Card de benefícios */
		.tooltip {
			position: absolute;
		    left: 225%;
            top: -1%;
			transform: translateX(-50%);
			background-color: #222;
			color: #fff;
			padding: 10px;
			border-radius: 8px;
			font-size: 14px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
			opacity: 0;
			visibility: hidden;
			transition: opacity 0.4s ease, transform 0.4s ease;
			width: 200px;
			text-align: start;
		}

		/* Seta abaixo do card */
		.tooltip::after {
			content: '';
			position: absolute;
			top: -5px;
			left: 50%;
			transform: translateX(-50%);
			border-width: 5px;
			border-style: solid;
			border-color: transparent transparent #222 transparent;
		}

		/* Exibir o card ao hover no badge */
		.badge:hover .tooltip {
			opacity: 1;
			visibility: visible;
			transform: translate(-50%, 0);
		}
	</style>
<style>
    /* Estilos para o tema Dark */
.cash-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
    align-items: center;
    justify-items: center;
    
}


.cash-card {
    background-color: #2c2f38;  /* Fundo escuro para os cards */
    border: 1px solid #444;
    padding: 20px;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
   
}
.cash-card  {
    background-image: url("<?php echo base_url()?>assets/images/bg-card.png");
}

.ref_coin_1 {
    background-image: url("<?php echo base_url()?>assets/images/modedas_1.png");
    width: 41px;
    height: 34px;
    top: 13px;
    right: 30px;
    border-radius: 10px;
    background-size: revert;
    z-index: 1;
    position: absolute;
    background-size: contain;
}
.ref_coin_2 {
    background-image: url("<?php echo base_url()?>assets/images/modedas_2.png");
    width: 41px;
    height: 34px;
    top: 13px;
    right: 30px;
    border-radius: 10px;
    background-size: revert;
    z-index: 1;
    position: absolute;
    background-size: contain;
}
.ref_coin_3 {
    background-image: url("<?php echo base_url()?>assets/images/modedas_3.png");
    width: 41px;
    height: 34px;
    top: 13px;
    right: 23px;
    border-radius: 10px;
    background-size: revert;
    z-index: 1;
    position: absolute;
    background-size: contain;
}
.cash-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
    
}

.cash-card h3 {
    font-size: 1.5rem;
    margin: 10px 0;
    color: #f1f1f1;  /* Texto claro */
}

.cash-card p {
    font-size: 1.2rem;
    margin: 10px 0;
    color: #00e676;  /* Verde para destacar o preço */
}


</style>
<style>
        .copy-container {
            display: flex;
            align-items: center;
            font-size: 16px;
           
            padding: 8px;
            border-radius: 5px;
            max-width: 250px;
            margin-top: 20px;
        }

        .copy-text {
            margin-right: 10px;
            color: #e1e1e1;
            font-weight: bold;
        }

        .copy-icon {
            cursor: pointer;
            color: #007bff;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .copy-icon:hover {
            color: #0056b3;
        }

        /* Estilo da mensagem de sucesso */
        .message {
            margin-top: 10px;
            color: green;
            font-weight: bold;
        }
    </style>
<style>
    #password-form {
    background-color: #1e1e1e;
    border: 1px solid #ddd;
    padding: 20px;
    max-width: 445px;
    margin: 0 auto;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

#password-form h3 {
    text-align: center;
    color: #ffffff;
    font-size: 20px;
    margin-bottom: 20px;
}

#password-form label {
    font-size: 14px;
    color: #ffffff;
    margin-bottom: 5px;
    display: block;
}

#password-form input[type="password"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

#password-form input[type="password"]:focus {
    border-color: #007bff;
    outline: none;
}

#password-form input[type="submit"] {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    background-color: chocolate;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#password-form input[type="submit"]:hover {
    background-color: #218838;
}

#password-form input[type="submit"]:focus {
    outline: none;
}

	/* Global styles */



/* Profile Header */
.profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
    border-bottom: 2px solid #333;
    padding-bottom: 20px;
}

.avatar {
    margin-right: 20px;
    border-radius: 50%;
    overflow: hidden;
}

.avatar img {
    width: 120px;
    height: 113px;
    object-fit: cover;

}

.profile-info {
    flex-grow: 1;
}

.profile-info h1 {
    font-size: 28px;
    margin-bottom: 10px;
}

.badge {
    background-color: #4CAF50;
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    margin-right: 10px;
}



/* Stats Section */
.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    background-color: #1E1E1E;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    border: 1px solid #333;
}

.card h3 {
    font-size: 36px;
    margin-bottom: 10px;
}

.card p {
    color: #B0B0B0;
    font-size: 14px;
}

/* Navigation Tabs */
.tabs {
    display: flex;
    gap: 20px;
    border-bottom: 2px solid #333;
    margin-bottom: 30px;
}

.tab {
    padding: 10px 20px;
    font-size: 16px;
    color: #B0B0B0;
    cursor: pointer;
}

.tab:hover {
    color: white;
}

.tab.active {
    color: #FF9800;
    border-bottom: 3px solid #FF9800;
}

/* Tab Content */
#tab-content div {
    display: none;
}

#tab-content div.active {
    display: block;
}

/* Favorite Games */
.favorite-games {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.game-card {
    background-color: #1E1E1E;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #333;
    text-align: center;
}

.game-card h4 {
    font-size: 18px;
    margin-bottom: 10px;
}

.game-card p {
    color: #B0B0B0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats {
        grid-template-columns: 1fr;
    }

    .favorite-games {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 480px) {
    .profile-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .tabs {
        flex-direction: column;
        align-items: flex-start;
    }

    .favorite-games {
        grid-template-columns: 1fr;
    }
}

</style>
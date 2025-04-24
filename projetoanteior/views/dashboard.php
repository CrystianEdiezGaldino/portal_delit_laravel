
<style>
    /* Estilos Globais */
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.tab-button {
    padding: 10px 20px;
    background-color: #f1f1f1;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.tab-button.active {
    background-color: #007bff;
    color: #fff;
}

.tab-button:hover {
    background-color: #ddd;
}

.tab-content {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    background-color: #f9f9f9;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

.status-concluido {
    color: #28a745;
    font-weight: bold;
}

.status-andamento {
    color: #ffc107;
    font-weight: bold;
}

.status-pendente {
    color: #dc3545;
    font-weight: bold;
}
</style>
<div class="portal-maconico">
    <h1>Bem-vindo ao Portal Delit Curitiba</h1>
    <p> Delit Curitiba atualizou o Portal Maçônico com o objetivo de facilitar o acompanhamento das informações pelos nossos Obreiros.</p>

    <!-- Card da Anuidade -->
    <div class="card">
        <h3>Anuidade 2025</h3>
        <p>Status: <strong>Aguardando pagamento</strong></p>
        <p>Valor da Anuidade com desconto: <strong>R$ 265,00</strong></p>
        <button class="btn-pagamento">Pagar Agora</button>
    </div>

    <!-- Card de Serviços Disponíveis -->
    <div class="card">
        <h3>Serviços Disponíveis</h3>
        <ul>
            <li>✔ Pagar a elevação de grau parcelada em até 3x.</li>
            <li>✔ Pagar sua anuidade através de boleto ou cartão.</li>
            <li>✔ Acessar sua identificação Maçônica Escocesa Digital.</li>
            <li>✔ Acessar e fazer download dos Diplomas Digitais.</li>
            <li>✔ Consultar sua Regularidade perante o Supremo Conselho do Brasil.</li>
            <li>✔ Consultar e solicitar alteração dos seus dados cadastrais.</li>
        </ul>
    </div>

    <!-- Card de Dados Fictícios -->
    <div class="card">
        <h3>Dados do Obreiro</h3>
        <p><strong>Nome:</strong> <?php echo utf8_encode($user_data['cadastro']); ?> </p>
        <p><strong>Grau:</strong> <?php echo utf8_encode(($user_data['ativo_no_grau'])); ?></p>
        <p><strong>Loja:</strong> <?php echo utf8_encode($user_data['potencia_corpo_filosofico']); ?> </p>
        <p><strong>Regularidade:</strong> <?php echo utf8_encode($user_data['tipo_categoria']); ?> </p>
        <p><strong>Local:</strong> <?php echo utf8_encode($user_data['cidade']); ?> </p>

    </div>
</div>
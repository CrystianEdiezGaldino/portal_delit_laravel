<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="portal-maconico">
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="card-header">
                    <h3 class="card-title">Delegacias</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($delegacias) && !empty($delegacias)): ?>
                        <div class="row">
                            <?php foreach ($delegacias as $delegacia): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $delegacia['nome']; ?></h5>
                                            <p class="card-text">
                                                <strong>Endereço:</strong><br>
                                                <?php echo $delegacia['endereco']; ?><br>
                                                <?php echo $delegacia['cidade']; ?> - <?php echo $delegacia['estado']; ?><br>
                                                CEP: <?php echo $delegacia['cep']; ?>
                                            </p>
                                            <?php if (!empty($delegacia['telefone'])): ?>
                                                <p class="card-text">
                                                    <strong>Telefone:</strong><br>
                                                    <?php echo $delegacia['telefone']; ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if (!empty($delegacia['email'])): ?>
                                                <p class="card-text">
                                                    <strong>E-mail:</strong><br>
                                                    <a href="mailto:<?php echo $delegacia['email']; ?>"><?php echo $delegacia['email']; ?></a>
                                                </p>
                                            <?php endif; ?>
                                            <?php if (!empty($delegacia['horario_atendimento'])): ?>
                                                <p class="card-text">
                                                    <strong>Horário de Atendimento:</strong><br>
                                                    <?php echo $delegacia['horario_atendimento']; ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if (!empty($delegacia['responsavel'])): ?>
                                                <p class="card-text">
                                                    <strong>Responsável:</strong><br>
                                                    <?php echo $delegacia['responsavel']; ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Nenhuma delegacia cadastrada no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

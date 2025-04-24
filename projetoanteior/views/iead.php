<?php 
// Configurações iniciais
$grau_atual = isset($_GET['grau']) ? (int)$_GET['grau'] : 4;
?>

<style>
.portal-maconico {
    padding: 20px;


}

h1 {
    color: var(--primary-color);
    margin-bottom: 2rem;
    font-size: 2.2rem;
    border-bottom: 2px solid var(--bg-light);
    padding-bottom: 1rem;
    margin-top: 1rem;
    text-align: center;
}

.tabs {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    width: 100%;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
}

.tab-button {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    background: var(--secondary-color);
    color: var(--bg-light);
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    min-width: 120px;
    text-align: center;
}

.tab-button:hover {
    background: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.tab-button.active {
    background: var(--primary-color);
    box-shadow: 0 4px 12px rgba(150, 0, 24, 0.2);
}

/* #conteudo {
    min-height: 300px;
    padding: 2rem;
    border-radius: 12px;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
} */

#loading {
    display: none;
    text-align: center;
    padding: 2rem;
    color: var(--primary-color);
    font-weight: 500;
}

.loading-spinner {
    animation: spin 1s linear infinite;
    width: 40px;
    height: 40px;
    border: 4px solid var(--bg-light);
    border-top-color: var(--primary-color);
    border-radius: 50%;
    display: inline-block;
    margin-right: 12px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.conteudo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 1rem;
}

.conteudo-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.conteudo-card:hover {
    transform: translateY(-5px);
}

.conteudo-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.conteudo-info {
    padding: 1rem;
}

.conteudo-titulo {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--primary-color);
}

.conteudo-descricao {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1rem;
}

.conteudo-botao {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background 0.3s ease;
}

.conteudo-botao:hover {
    background: var(--secondary-color);
}

@media (max-width: 768px) {
    .portal-maconico {
        padding: 10px;
    }
    
    .tabs {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .tab-button {
        min-width: 100px;
        padding: 8px 16px;
    }
    
    .conteudo-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="portal-maconico">
    <h1>IEAD - Instruções Escocesas a Distância</h1>

    <?php
    // Lista de graus ordenados
    $graus = [4, 7, 9, 10, 14, 15, 16, 17, 18, 19, 22, 29, 30, 31, 32, 33];

    // Obtendo o grau do usuário
    $grau_usuario = isset($user_data['ativo_no_grau']) ? (int) $user_data['ativo_no_grau'] : 0;
    ?>

    <div class="tabs">
        <?php foreach ($graus as $grau): ?>
        <?php if ($grau <= $grau_usuario): ?>
        <button class="tab-button" onclick="carregarConteudo(<?php echo $grau; ?>)">Grau <?php echo $grau; ?></button>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div id="loading">
        <div class="loading-spinner"></div>
        Carregando conteúdo...
    </div>
    <div id="conteudo">Clique em uma aba para carregar o conteúdo.</div>
</div>

<script>
function carregarConteudo(grau) {
    // Ativar estado do botão
    $('.tab-button').removeClass('active');
    $(`button:contains("Grau ${grau}")`).addClass('active');
    
    // Mostrar loading
    $('#loading').show();
    $('#conteudo').hide();

    $.ajax({
        url: "<?php echo base_url().'setgrau'; ?>",
        type: "POST",
        data: {
            grau: grau
        },
        success: function(response) {
            $("#conteudo").html(response).fadeIn();
            $('#loading').hide();
            
            // Inicializa os modais do Bootstrap
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                new bootstrap.Modal(modal);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#loading').hide();
            $('#conteudo').html('<div class="alert alert-danger">Erro ao carregar o conteúdo. Por favor, tente novamente.</div>').fadeIn();
        }
    });
}

// Previne o download do vídeo
document.addEventListener('contextmenu', function(e) {
    if (e.target.tagName === 'VIDEO') {
        e.preventDefault();
    }
});

// Desabilita o menu de contexto do vídeo
document.addEventListener('DOMContentLoaded', function() {
    var videos = document.querySelectorAll('video');
    videos.forEach(function(video) {
        video.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    });
});
</script>
</body>

</html>

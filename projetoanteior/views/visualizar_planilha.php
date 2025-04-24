<div class="portal-maconico">
    <h1><?php echo $planilha['nome']; ?></h1>

<!-- Link para baixar o PDF -->
<a href="<?php echo base_url($planilha['caminho']); ?>" class="btn btn-primary btn-default" download>
    <i class="bi bi-download"></i> Baixar PDF
</a>

<!-- Iframe para visualizar o PDF -->
 <div style=" height: 100vh; ">
 <iframe src="<?php echo base_url($planilha['caminho']); ?>" width="100%" height="80%" style="border: none;"></iframe>  
 </div>

</div>
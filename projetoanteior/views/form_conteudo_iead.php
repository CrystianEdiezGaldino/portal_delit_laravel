<?php if ($user_data['role'] == "admin"): ?>
<div  class="portal-maconico">
    <h1><?php echo isset($conteudo) ? 'Editar Conteúdo' : 'Criar Conteúdo'; ?></h1>

    <!-- Exibir mensagens de sucesso ou erro -->
    <!-- <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?> -->

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" class="form-control" value="<?php echo isset($conteudo) ? $conteudo['titulo'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" class="form-control" required><?php echo isset($conteudo) ? $conteudo['descricao'] : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="grau">Grau</label>
            <select name="grau" class="form-control" required>
                <?php foreach ([4, 7, 9, 10, 14, 15, 16, 17, 18, 19, 22, 29, 30, 31, 32, 33] as $grau): ?>
                <option value="<?php echo $grau; ?>" <?php echo isset($conteudo) && $conteudo['grau'] == $grau ? 'selected' : ''; ?>>Grau <?php echo $grau; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="tipo_conteudo">Tipo de Conteúdo</label>
            <select name="tipo_conteudo" class="form-control" required>
                <option value="video" <?php echo isset($conteudo) && $conteudo['tipo_conteudo'] == 'video' ? 'selected' : ''; ?>>Vídeo</option>
                <option value="imagem" <?php echo isset($conteudo) && $conteudo['tipo_conteudo'] == 'imagem' ? 'selected' : ''; ?>>Imagem</option>
                <option value="texto" <?php echo isset($conteudo) && $conteudo['tipo_conteudo'] == 'texto' ? 'selected' : ''; ?>>Texto</option>
                <option value="arquivo" <?php echo isset($conteudo) && $conteudo['tipo_conteudo'] == 'arquivo' ? 'selected' : ''; ?>>Arquivo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="arquivo">Arquivo</label>
            <input type="file" name="arquivo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<?php endif; ?>
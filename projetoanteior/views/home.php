<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Bem-vindo, <?php echo htmlspecialchars($user_data['cadastro']); ?></h2>
    <a href="<?php echo site_url('main/logout'); ?>" class="btn btn-outline-danger">Sair</a>
  </div>

  <div class="card">
    <div class="card-body">
      <h3 class="card-title mb-4">Dados do Usuário</h3>
      <div class="row">
        <?php foreach ($user_data as $key => $value): ?>
          <div class="col-md-6 mb-3">
            <strong><?php echo htmlspecialchars($key); ?>:</strong>
            <?php echo htmlspecialchars($value); ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

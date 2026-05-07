<?php include_once("cabec.php"); ?>

<style>
  body {
    background-color: #f2f2f2;
  }
  .container-form {
    max-width: 600px;
    margin: 50px auto;
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  }
  .container-form h2 {
    color: #1986a4;
    margin-bottom: 30px;
    text-align: center;
  }
  .form-group {
    margin-bottom: 20px;
  }
  .form-group label {
    font-weight: bold;
  }
  .form-group input {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
  }
  .btn-custom {
    width: 100%;
    padding: 10px;
    background-color: #1986a4;
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    transition: 0.3s;
  }
  .btn-custom:hover {
    background-color: #145f77;
  }
</style>

<div class="container-form">
  <h2><?= $lng['cadastroUsuario'] ?></h2>
  <form method="POST" action="salvarCadastro.php">
    <div class="form-group">
      <label><?= $lng['nome'] ?>:</label>
      <input type="text" name="nome" required>
    </div>
    <div class="form-group">
      <label><?= $lng['cpf'] ?>:</label>
      <input type="text" name="cpf" id="cpf" required maxlength="14">
    </div>
    <div class="form-group">
      <label><?= $lng['telefone'] ?>:</label>
      <input type="text" name="telefone" required>
    </div>
    <div class="form-group">
      <label><?= $lng['senha'] ?>:</label>
      <input type="password" name="senha" required>
    </div>
    <button type="submit" class="btn-custom"><?= $lng['cadastrar'] ?></button>
  </form>
</div>

<script>
  document.getElementById('cpf').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = value;
  });
</script>

<?php include_once("rodape.php"); ?>

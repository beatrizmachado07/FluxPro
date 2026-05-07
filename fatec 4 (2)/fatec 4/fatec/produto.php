<?php
  include_once("cabec.php");

  $data = $_REQUEST;
  extract($data);

  if (isset($pesquisa)) {
    $pesquisa = "%" . $pesquisa . "%";
  } else {
    $pesquisa = "%";
  }

  include_once("config.php");
  $conexao = db_connect();

  $sql = "SELECT * FROM produto WHERE proDescricao LIKE :pesquisa ORDER BY proDescricao";
  $comando = $conexao->prepare($sql);
  $comando->bindParam(':pesquisa', $pesquisa);
  $comando->execute();
  $dados = $comando->fetchAll(PDO::FETCH_OBJ);
?>

<style>
  body {
    background-color: #f0f4f8;
    font-family: Arial, sans-serif;
  }

  #container {
    max-width: 1000px;
    margin: auto;
    padding: 30px;
  }

  .titulo-box {
    background-color: #1986a4;
    color: white;
    padding: 30px;
    border-radius: 20px;
    text-align: center;
    margin-bottom: 30px;
  }

  form[name="pesquisa"] {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  form input[type="text"], form input[type="number"] {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    flex: 1;
    min-width: 200px;
  }

  form input[type="submit"], .btn {
    background-color: #1986a4;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    cursor: pointer;
    text-decoration: none;
  }

  .form-box {
    background-color: #1986a4;
    padding: 40px;
    border-radius: 25px;
    max-width: 600px;
    margin: 40px auto;
  }

  .form-box form {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .form-box input {
    padding: 15px;
    border-radius: 30px;
    border: 1px solid #ccc;
    background-color: white;
    color: black;
    font-size: 16px;
    width: 100%;
  }

  .form-box button {
    background-color: transparent;
    color: white;
    border: 2px solid white;
    border-radius: 25px;
    padding: 10px 30px;
    font-size: 16px;
    cursor: pointer;
    align-self: center;
  }

  .form-box button:hover {
    background-color: white;
    color: #1986a4;
  }

  .table-wrapper {
    margin-top: 40px;
    overflow-x: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
  }

  th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ccc;
  }

  th {
    background-color: #1986a4;
    color: white;
  }

  tr:hover {
    background-color: #f1f1f1;
  }
</style>

<div id="container">
  <div class="titulo-box">
    <h2>Cadastro de Produtos</h2>
  </div>

  <!-- formulário de pesquisa -->
  <form name="pesquisa" action="produto.php" method="GET">
    <input type="text" name="pesquisa" placeholder="Digite uma descrição">
    <input type="submit" value="Pesquisar">
  </form>

  <!-- formulário de cadastro -->
  <div class="form-box">
    <form action="salvarProduto.php" method="POST">
      <input type="text" name="proDescricao" placeholder="Descrição do produto" required>
      <input type="number" name="proQuantidade" step="0.01" placeholder="Quantidade" required>
      <input type="number" name="proValor" step="0.01" placeholder="Valor" required>
      <input type="number" name="proSetor" placeholder="Código do Setor" required>
      <input type="text" name="proStatus" maxlength="1" placeholder="Status (A/I)" required>
      <button type="submit">Cadastrar</button>
    </form>
  </div>

  <!-- Tabela de produtos -->
  <div class="table-wrapper">
    <table>
      <tr>
        <th>Descrição</th>
        <th>Quantidade</th>
        <th>Valor</th>
        <th>Setor</th>
        <th>Status</th>
      </tr>
      <?php foreach ($dados as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p->proDescricao) ?></td>
          <td><?= htmlspecialchars($p->proQuantidade) ?></td>
          <td>R$ <?= number_format($p->proValor, 2, ',', '.') ?></td>
          <td><?= htmlspecialchars($p->proSetor) ?></td>
          <td><?= htmlspecialchars($p->proStatus) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<?php include_once("rodape.php"); ?>

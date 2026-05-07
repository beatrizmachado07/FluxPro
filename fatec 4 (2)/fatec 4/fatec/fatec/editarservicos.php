<?php
include_once("cabec.php");
include_once("config.php");

$conexao = db_connect();

$id = $_GET['codigo'] ?? null;

if (!$id) {
    echo "<p>Código inválido.</p>";
    include_once("rodape.php");
    exit;
}

$sql = "SELECT * FROM servicos WHERE codigo = :id";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$servico = $stmt->fetch(PDO::FETCH_OBJ);

if (!$servico) {
    echo "<p>Serviço não encontrado.</p>";
    include_once("rodape.php");
    exit;
}
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

  .form-box input::placeholder {
    color: #666;
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
</style>

<div id="container">
  <div class="titulo-box">
    <h2><?= $lng['editarServico'] ?></h2>
  </div>

  <div class="form-box">
    <form action="atualizarservicos.php" method="POST">
      <input type="hidden" name="codigo" value="<?= $servico->codigo ?>">

      <input type="text" name="nome" placeholder="<?= $lng['nomeServico'] ?>" value="<?= htmlspecialchars($servico->nome) ?>" required>

      <input type="text" name="descricao" placeholder="<?= $lng['descricao'] ?>" value="<?= htmlspecialchars($servico->descricao) ?>" required>

      <input type="number" name="preco" step="0.01" placeholder="<?= $lng['valor'] ?>" value="<?= htmlspecialchars($servico->preco) ?>" required>

      <button type="submit"><?= $lng['salvarAlteracoes'] ?></button>
    </form>
  </div>
</div>


<?php include_once("rodape.php"); ?>

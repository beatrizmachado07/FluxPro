<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("cabec.php");
include_once("config.php");

$conexao = db_connect();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p>ID inválido.</p>";
    include_once("rodape.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['proDescricao'] ?? '';
    $quantidade = $_POST['proQuantidade'] ?? 0;
    $valor = $_POST['proValor'] ?? 0;
    $setor = $_POST['proSetor'] ?? '';
    $status = $_POST['proStatus'] ?? 'A'; // pegar status, padrão 'A'

    if ($descricao && $quantidade !== '' && $valor !== '' && $setor && ($status === 'A' || $status === 'I')) {
        $sql = "UPDATE produto 
                SET proDescricao = :descricao, proQuantidade = :quantidade, 
                    proValor = :valor, proSetor = :setor, proStatus = :status
                WHERE proCodigo = :id";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':setor', $setor);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: produto.php");
        exit;
    } else {
        echo "<p style='color: red; text-align:center;'>Por favor, preencha todos os campos corretamente.</p>";
    }
}

$sql = "SELECT * FROM produto WHERE proCodigo = :id";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_OBJ);

if (!$produto) {
    echo "<p>Produto não encontrado.</p>";
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

  .form-box input, .form-box select {
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
    <h2><?= $lng['editarProduto'] ?></h2>
  </div>

  <div class="form-box">
    <form action="editarProduto.php?id=<?= $produto->proCodigo ?>" method="POST">
      <input type="text" name="proDescricao" value="<?= htmlspecialchars($produto->proDescricao) ?>" placeholder="<?= $lng['descricao'] ?>" required>
      <input type="number" step="0.01" name="proQuantidade" value="<?= $produto->proQuantidade ?>" placeholder="<?= $lng['quantidade'] ?>" required>
      <input type="number" step="0.01" name="proValor" value="<?= $produto->proValor ?>" placeholder="<?= $lng['valor'] ?>" required>
      <input type="text" name="proSetor" value="<?= htmlspecialchars($produto->proSetor) ?>" placeholder="<?= $lng['setor'] ?>" required>

      <select name="proStatus" id="proStatus" required>
        <option value="A" <?= $produto->proStatus === 'A' ? 'selected' : '' ?>><?= $lng['ativo'] ?></option>
        <option value="I" <?= $produto->proStatus === 'I' ? 'selected' : '' ?>><?= $lng['inativo'] ?></option>
      </select>

      <button type="submit"><?= $lng['salvarAlteracoes'] ?></button>
    </form>
  </div>
</div>


<?php include_once("rodape.php"); ?>

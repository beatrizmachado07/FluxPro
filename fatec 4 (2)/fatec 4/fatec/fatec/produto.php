<?php
// produto.php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("cabec.php");
include_once("config.php");

// Verificação de login
if (!isset($_SESSION["codUsuario"])) {
  echo "<script>
          alert('Você precisa estar logada para acessar a página de produtos.');
          window.location.href = 'login.php';
        </script>";
  exit;
}

$conexao = db_connect();
$codUsuario = $_SESSION["codUsuario"];

// Pesquisa
$pesquisa_raw = $_GET['pesquisa'] ?? '';
$pesquisa = ($pesquisa_raw !== '') ? "%{$pesquisa_raw}%" : "%";

// Cadastro
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $proDescricao = trim($_POST["proDescricao"] ?? "");
  $proQuantidade = trim($_POST["proQuantidade"] ?? "");
  $proValor = trim($_POST["proValor"] ?? "");
  $proSetor = trim($_POST["proSetor"] ?? "");
  $proStatus = trim($_POST["proStatus"] ?? "A");

  if ($proDescricao !== "" && $proValor !== "") {
    $sql = "INSERT INTO produto (proDescricao, proQuantidade, proValor, proSetor, proStatus, codUsuario)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$proDescricao, $proQuantidade, $proValor, $proSetor, $proStatus, $codUsuario]);
    header("Location: produto.php");
    exit;
  }
}

// Seleção
$sql = "SELECT proCodigo, proDescricao, proQuantidade, proValor, proSetor, proStatus
        FROM produto
        WHERE codUsuario = :codUsuario
          AND proDescricao LIKE :pesquisa
        ORDER BY proDescricao";
$comando = $conexao->prepare($sql);
$comando->bindParam(':codUsuario', $codUsuario);
$comando->bindParam(':pesquisa', $pesquisa);
$comando->execute();
$produtos = $comando->fetchAll(PDO::FETCH_OBJ);
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
    margin-bottom: 20px;
  }

  /* Campo de pesquisa fora do azul (idêntico ao de pessoas) */
  .pesquisa-form {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .pesquisa-form input[type="text"] {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    flex: 1;
    min-width: 200px;
    max-width: 800px;
  }

  .pesquisa-form button {
    background-color: #1986a4;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
  }

  .pesquisa-form button:hover {
    background-color: #14748d;
  }

  /* Formulário */
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

  /* Botão idêntico ao do cadastro de pessoas */
  .form-box button {
    background-color: transparent;
    color: white;
    border: 2px solid white;
    border-radius: 25px;
    padding: 10px 30px;
    font-size: 16px;
    cursor: pointer;
    align-self: center;
    transition: 0.3s;
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

  .btn {
    background-color: #1986a4;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    cursor: pointer;
    text-decoration: none;
  }

  .btn img {
    width: 20px;
    height: 20px;
    display: inline-block;
    vertical-align: middle;
  }
</style>

<div id="container">
  <!-- Título -->
  <div class="titulo-box">
    <h2><?= $lng['cadastroProdutos'] ?? 'Cadastro de Produtos' ?></h2>
  </div>

  <!-- Pesquisa -->
  <form class="pesquisa-form" name="pesquisa" action="produto.php" method="GET">
    <input type="text" name="pesquisa" placeholder="<?= $lng['digiteDescricao'] ?? 'Digite uma descrição:' ?>" value="<?= htmlspecialchars($pesquisa_raw) ?>">
    <button type="submit"><?= $lng['pesquisar'] ?? 'Pesquisar' ?></button>
  </form>

  <!-- Formulário -->
  <div class="form-box">
    <form action="produto.php" method="POST">
      <input type="text" name="proDescricao" placeholder="<?= $lng['descricaoProduto'] ?? 'Descrição do Produto' ?>" required>
      <input type="number" step="1" name="proQuantidade" placeholder="<?= $lng['quantidade'] ?? 'Quantidade' ?>">
      <input type="number" step="0.01" name="proValor" placeholder="<?= $lng['valor'] ?? 'Valor (R$)' ?>" required>
      <input type="text" name="proSetor" placeholder="<?= $lng['setor'] ?? 'Setor' ?>">
      <input type="text" name="proStatus" placeholder="<?= $lng['status'] ?? 'Status (A/I)' ?>" maxlength="1">
      <button type="submit"><?= $lng['cadastrar'] ?? 'Cadastrar' ?></button>
    </form>
  </div>

  <!-- Tabela -->
  <div class="table-wrapper">
    <table>
      <tr>
        <th><?= $lng['descricao'] ?? 'Descrição' ?></th>
        <th><?= $lng['quantidade'] ?? 'Quantidade' ?></th>
        <th><?= $lng['valor'] ?? 'Valor (R$)' ?></th>
        <th><?= $lng['setor'] ?? 'Setor' ?></th>
        <th><?= $lng['status'] ?? 'Status' ?></th>
        <th><?= $lng['editar'] ?? 'Editar' ?></th>
      </tr>

      <?php if (!empty($produtos)): ?>
        <?php foreach ($produtos as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p->proDescricao) ?></td>
            <td><?= htmlspecialchars($p->proQuantidade) ?></td>
            <td>R$ <?= number_format($p->proValor, 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($p->proSetor) ?></td>
            <td><?= htmlspecialchars($p->proStatus) ?></td>
            <td>
              <a href="editarProduto.php?id=<?= $p->proCodigo ?>" class="btn">
                <img src="icones/imagem_editar_png.png" alt="Editar">
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6" style="text-align:center;">Nenhum produto cadastrado ainda.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</div>

<?php include_once("rodape.php"); ?>

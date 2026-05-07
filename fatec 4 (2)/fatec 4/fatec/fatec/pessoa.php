<?php
// pessoa.php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once("cabec.php");
include_once("config.php");

// verificação de login
if (!isset($_SESSION["codUsuario"])) {
  echo "<script>
          alert('Você precisa estar logada para acessar a página de pessoas.');
          window.location.href = 'login.php';
        </script>";
  exit;
}

$conexao = db_connect();
$codUsuario = $_SESSION["codUsuario"];

// Pesquisa
$pesquisa_raw = $_GET['pesquisa'] ?? '';
$pesquisa = ($pesquisa_raw !== '') ? "%{$pesquisa_raw}%" : "%";

// Seleção
$sql = "SELECT pesCodigo, pesNome, pesTelefone, pesDocumento
        FROM pessoa
        WHERE codUsuario = :codUsuario
          AND pesNome LIKE :pesquisa
        ORDER BY pesNome";
$comando = $conexao->prepare($sql);
$comando->bindParam(':codUsuario', $codUsuario);
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
    margin-bottom: 20px;
  }

  /*  Campo de pesquisa fora do azul (idêntico ao produto.php) */
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

  /* botão */
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

  /* Tabela */
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
    <h2><?= $lng['cadastroPessoas'] ?? 'Cadastro de Pessoas' ?></h2>
  </div>

  <!-- Pesquisa -->
  <form class="pesquisa-form" name="pesquisa" action="pessoa.php" method="GET">
    <input type="text" name="pesquisa" placeholder="<?= $lng['digiteNome'] ?? 'Digite um nome:' ?>" value="<?= htmlspecialchars($pesquisa_raw) ?>">
    <button type="submit"><?= $lng['pesquisar'] ?? 'Pesquisar' ?></button>
  </form>

  <!-- Cadastro -->
  <div class="form-box">
    <form action="salvarPessoa.php" method="POST">
      <input type="text" name="pesNome" placeholder="<?= $lng['nome'] ?? 'Nome' ?>" required>
      <input type="text" name="pesTelefone" placeholder="<?= $lng['telefone'] ?? 'Telefone' ?>" required>
      <input type="text" name="pesDocumento" placeholder="<?= $lng['cpf'] ?? 'CPF' ?>" required>
      <button type="submit"><?= $lng['cadastrar'] ?? 'Cadastrar' ?></button>
    </form>
  </div>

  <!-- Tabela -->
  <div class="table-wrapper">
    <table>
      <tr>
        <th><?= $lng['nome'] ?? 'Nome' ?></th>
        <th><?= $lng['telefone'] ?? 'Telefone' ?></th>
        <th><?= $lng['cpf'] ?? 'CPF' ?></th>
        <th><?= $lng['editar'] ?? 'Editar' ?></th>
      </tr>

      <?php if (!empty($dados)): ?>
        <?php foreach ($dados as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p->pesNome) ?></td>
            <td><?= htmlspecialchars($p->pesTelefone) ?></td>
            <td><?= htmlspecialchars($p->pesDocumento) ?></td>
            <td>
              <a href="editarPessoa.php?id=<?= $p->pesCodigo ?>" class="btn">
                <img src="icones/imagem_editar_png.png" alt="Editar">
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="4" style="text-align:center;">Nenhuma pessoa cadastrada ainda.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</div>

<?php include_once("rodape.php"); ?>

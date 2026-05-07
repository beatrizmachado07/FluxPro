<?php
include_once("cabec.php");
include_once("config.php");

// Evita erro de sessão duplicada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION["codUsuario"])) {
  echo "<script>
          alert('Você precisa estar logada para acessar a página de serviços.');
          window.location.href = 'login.php';
        </script>";
  exit;
}

$conexao = db_connect();

// pesquisa
$pesquisa_raw = $_GET['pesquisa'] ?? '';
$pesquisa = ($pesquisa_raw !== '') ? "%{$pesquisa_raw}%" : "%";
$codUsuario = $_SESSION["codUsuario"]; // pega o código do usuário logado

// busca somente os serviços do usuário logado
$sql = "SELECT codigo, nome, descricao, preco 
        FROM servicos 
        WHERE nome LIKE :pesquisa AND codUsuario = :codUsuario 
        ORDER BY nome";

$comando = $conexao->prepare($sql);
$comando->bindParam(':pesquisa', $pesquisa);
$comando->bindParam(':codUsuario', $codUsuario);
$comando->execute();
$dados = $comando->fetchAll(PDO::FETCH_OBJ);
?>

<style>
  body {
    background-color: #edf2f7;
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

  /* Campo de pesquisa*/
  .pesquisa-form {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
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

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 40px;
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
    padding: 5px 10px;
    border-radius: 8px;
    text-decoration: none;
  }

  .btn img {
    vertical-align: middle;
  }

  .sem-registro {
    text-align: center;
    padding: 20px;
    color: #555;
  }
</style>

<div id="container">
  <div class="titulo-box">
    <h2><?= $lng['cadastroServicos'] ?? 'Cadastro de Serviços' ?></h2>
  </div>

  <!-- pesquisa -->
  <form class="pesquisa-form" name="pesquisa" action="servicos.php" method="GET">
    <input type="text" name="pesquisa" placeholder="<?= $lng['digiteNome'] ?? 'Digite um nome:' ?>" value="<?= htmlspecialchars($pesquisa_raw) ?>">
    <button type="submit"><?= $lng['pesquisar'] ?? 'Pesquisar' ?></button>
  </form>

  <!--Cadastro -->
  <div class="form-box">
    <form action="salvarservicos.php" method="POST">
      <input type="text" name="nome" placeholder="<?= $lng['nomeServico'] ?? 'Nome do Serviço' ?>" required>
      <input type="text" name="descricao" placeholder="<?= $lng['descricao'] ?? 'Descrição' ?>" required>
      <input type="text" name="preco" placeholder="<?= $lng['valor'] ?? 'Preço (R$)' ?>" required>
      <button type="submit"><?= $lng['cadastrar'] ?? 'Cadastrar' ?></button>
    </form>
  </div>

  <!-- Tabela -->
  <table>
    <tr>
      <th><?= $lng['nome'] ?? 'Nome' ?></th>
      <th><?= $lng['descricao'] ?? 'Descrição' ?></th>
      <th><?= $lng['valor'] ?? 'Preço' ?></th>
      <th><?= $lng['editar'] ?? 'Editar' ?></th>
    </tr>

    <?php if (count($dados) > 0): ?>
      <?php foreach ($dados as $s): ?>
        <tr>
          <td><?= htmlspecialchars($s->nome) ?></td>
          <td><?= htmlspecialchars($s->descricao) ?></td>
          <td>R$ <?= number_format($s->preco, 2, ',', '.') ?></td>
          <td>
            <a href="editarservicos.php?codigo=<?= $s->codigo ?>" class="btn" style="padding: 8px 12px;">
              <img src="icones/imagem_editar_png.png" alt="Editar" width="22">
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="4" class="sem-registro">Nenhum serviço cadastrado ainda.</td>
      </tr>
    <?php endif; ?>
  </table>
</div>

<?php include_once("rodape.php"); ?>

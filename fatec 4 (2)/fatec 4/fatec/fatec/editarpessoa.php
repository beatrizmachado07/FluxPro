<?php
include_once("cabec.php");
include_once("config.php");

$id = $_GET["id"] ?? null;
if (!$id) {
  echo "<p>ID inválido.</p>";
  exit;
}

$conexao = db_connect();

$sql = "SELECT * FROM pessoa WHERE pesCodigo = :id";
$comando = $conexao->prepare($sql);
$comando->bindParam(':id', $id);
$comando->execute();
$pessoa = $comando->fetch(PDO::FETCH_OBJ);

if (!$pessoa) {
  echo "<p>Pessoa não encontrada.</p>";
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
    <h2><?= $lng['editarPessoa'] ?></h2>
  </div>

  <div class="form-box">
    <form action="salvarPessoa.php" method="POST">
      <input type="hidden" name="pesCodigo" value="<?= $pessoa->pesCodigo ?>">
      <input type="text" name="pesNome" value="<?= htmlspecialchars($pessoa->pesNome) ?>" placeholder="<?= $lng['nome'] ?>" required>
      <input type="text" name="pesTelefone" value="<?= htmlspecialchars($pessoa->pesTelefone) ?>" placeholder="<?= $lng['telefone'] ?>" required>
      <input type="text" name="pesDocumento" value="<?= htmlspecialchars($pessoa->pesDocumento) ?>" placeholder="<?= $lng['cpf'] ?>" required>
      <button type="submit"><?= $lng['salvarAlteracoes'] ?></button>
    </form>
  </div>
</div>


<?php include_once("rodape.php"); ?>

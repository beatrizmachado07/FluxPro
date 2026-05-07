<?php
include_once("config.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pega o código do usuário logado
if (!isset($_SESSION["codUsuario"])) {
    echo "<script>
            alert('Você precisa estar logada para cadastrar serviços.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$codUsuario = $_SESSION["codUsuario"];
$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$preco = $_POST['preco'] ?? '';

if (!empty($nome) && !empty($descricao) && !empty($preco)) {
    $conexao = db_connect();

    $sql = "INSERT INTO servicos (nome, descricao, preco, codUsuario, serStatus)
            VALUES (:nome, :descricao, :preco, :codUsuario, 'A')";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':codUsuario', $codUsuario);

    $stmt->execute();
}

header("Location: servicos.php");
exit;
?>

<?php
include_once("config.php");

$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$senha = $_POST['senha'] ?? '';

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $conexao = db_connect();
    $stmt = $conexao->prepare("INSERT INTO usuario (usuNome, usuCPF, usuSenha, usuStatus) VALUES (:nome, :cpf, :senha, 'A')");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':senha', $senhaHash);
    $stmt->execute();
    header("Location: login.php");
    exit;
} catch (PDOException $e) {
    echo "Erro ao cadastrar usuário: " . $e->getMessage();
}
?>

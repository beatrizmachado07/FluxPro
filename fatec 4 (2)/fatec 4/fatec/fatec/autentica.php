<?php
session_start();
include_once("config.php");

$nome  = $_POST['nome'] ?? '';
$senha = $_POST['senha'] ?? '';

$conexao = db_connect();

$sql = "SELECT usuCodigo, usuNome, usuSenha FROM usuario WHERE usuNome = :nome";
$comando = $conexao->prepare($sql);
$comando->bindParam(':nome', $nome);
$comando->execute();

if ($comando->rowCount() === 1) {
    $usuario = $comando->fetch(PDO::FETCH_OBJ);

    if (password_verify($senha, $usuario->usuSenha)) {
        // Sessão com nomes consistentes
        $_SESSION['logged_in'] = true;
        $_SESSION['codUsuario'] = $usuario->usuCodigo; 
        $_SESSION['usuNome'] = $usuario->usuNome;
        $_SESSION['TEMPO'] = time();

        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?erro=1");
        exit();
    }
} else {
    header("Location: login.php?erro=1");
    exit();
}
?>

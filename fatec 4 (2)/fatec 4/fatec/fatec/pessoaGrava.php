<?php
session_start(); // Garante que a sessão está ativa

$data = $_REQUEST;
extract($data);

include_once("config.php");

$conexao = db_connect();

// Verifica se o usuário está logado antes de gravar
if (!isset($_SESSION['codUsuario'])) {
    die("Erro: usuário não autenticado.");
}

// Pega o código do usuário logado
$codUsuario = $_SESSION['codUsuario'];

// Agora insere junto o codUsuario
session_start();
include_once("config.php");

$conexao = db_connect();

if (!isset($_SESSION['codUsuario'])) {
    die("Erro: usuário não autenticado.");
}

$codUsuario = $_SESSION['codUsuario'];

$sql = "INSERT INTO produto (proDescricao, proQuantidade, proValor, codUsuario) 
        VALUES (:descricao, :quantidade, :valor, :codUsuario)";

$comando = $conexao->prepare($sql);
$comando->bindParam(':descricao', $descricao);
$comando->bindParam(':quantidade', $quantidade);
$comando->bindParam(':valor', $valor);
$comando->bindParam(':codUsuario', $codUsuario);

$comando->execute();

header('location: produto.php');

?>

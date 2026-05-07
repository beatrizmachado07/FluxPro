<?php
include_once("config.php");

$data = $_POST;

$conexao = db_connect();

$sql = "UPDATE servicos 
        SET nome = :nome, descricao = :descricao, preco = :preco 
        WHERE codigo = :codigo";

$comando = $conexao->prepare($sql);
$comando->bindParam(':nome', $data['nome']);
$comando->bindParam(':descricao', $data['descricao']);
$comando->bindParam(':preco', $data['preco']);
$comando->bindParam(':codigo', $data['codigo']);

$comando->execute();

// redireciona de volta para a lista
header("Location: servicos.php");
exit;
?>

<?php
include_once("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o usuário está logado
    if (!isset($_SESSION['codUsuario'])) {
        echo "<script>alert('Você precisa estar logado para cadastrar ou editar produtos!');window.location='login.php';</script>";
        exit;
    }

    $id = $_POST['proCodigo'] ?? null;
    $descricao = $_POST['proDescricao'] ?? '';
    $quantidade = $_POST['proQuantidade'] ?? 0;
    $valor = $_POST['proValor'] ?? 0;
    $setor = $_POST['proSetor'] ?? '';
    $status = $_POST['proStatus'] ?? 'A';
    $codUsuario = $_SESSION['codUsuario'];

    $conexao = db_connect();

    if ($id) {
        // Atualizar produto existente
        $sql = "UPDATE produto 
                SET proDescricao = :descricao, 
                    proQuantidade = :quantidade, 
                    proValor = :valor, 
                    proSetor = :setor,
                    proStatus = :status
                WHERE proCodigo = :id AND codUsuario = :codUsuario";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':codUsuario', $codUsuario);
    } else {
        // Inserir novo produto
        $sql = "INSERT INTO produto (proDescricao, proQuantidade, proValor, proSetor, proStatus, codUsuario) 
                VALUES (:descricao, :quantidade, :valor, :setor, :status, :codUsuario)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':codUsuario', $codUsuario);
    }

    // Bind dos outros campos
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':setor', $setor);
    $stmt->bindParam(':status', $status);

    $stmt->execute();

    header("Location: produto.php");
    exit;
}
?>

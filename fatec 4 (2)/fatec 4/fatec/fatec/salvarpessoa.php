<?php
include_once("config.php");
session_start();

$conexao = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['pesCodigo'] ?? null;
    $nome = $_POST['pesNome'] ?? '';
    $telefone = $_POST['pesTelefone'] ?? '';
    $documento = $_POST['pesDocumento'] ?? '';

    // Pega o usuário logado
    $codUsuario = $_SESSION["codUsuario"] ?? null;

    if ($nome && $telefone && $documento && $codUsuario) {
        if ($codigo) {
            // Atualizar pessoa existente
            $sql = "UPDATE pessoa 
                    SET pesNome = :nome, pesTelefone = :telefone, pesDocumento = :documento 
                    WHERE pesCodigo = :codigo AND codUsuario = :codUsuario";
            $comando = $conexao->prepare($sql);
            $comando->bindParam(':nome', $nome);
            $comando->bindParam(':telefone', $telefone);
            $comando->bindParam(':documento', $documento);
            $comando->bindParam(':codigo', $codigo);
            $comando->bindParam(':codUsuario', $codUsuario);
            $comando->execute();
        } else {
            // Inserir nova pessoa
            $sql = "INSERT INTO pessoa (pesNome, pesTelefone, pesDocumento, codUsuario) 
                    VALUES (:nome, :telefone, :documento, :codUsuario)";
            $comando = $conexao->prepare($sql);
            $comando->bindParam(':nome', $nome);
            $comando->bindParam(':telefone', $telefone);
            $comando->bindParam(':documento', $documento);
            $comando->bindParam(':codUsuario', $codUsuario);
            $comando->execute();
        }

        header("Location: pessoa.php");
        exit;
    } else {
        echo "Preencha todos os campos!";
    }
}
?>

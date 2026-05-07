<?php
    session_start();

    $dados = $_REQUEST;

    extract($dados);

    if( $email == "aaa@aaa" && $senha == "1234")
    {
        $_SESSION['nome'] = $email;
        header('location: .');
    }
    else
    {
        session_destroy();
        header('location: login_erro.php');
    }
?>
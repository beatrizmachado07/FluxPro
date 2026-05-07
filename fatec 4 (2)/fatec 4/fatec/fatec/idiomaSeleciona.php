<?php
// selecionaidioma.php
if (isset($_REQUEST['idioma'])) {
    $idioma = $_REQUEST['idioma'];

  
    setcookie('idioma', $idioma, time() + (30 * 24 * 60 * 60), "/");
}

// volta pra página anterior
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>

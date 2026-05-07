<?php
session_start();             // inicia a sessão atual
session_unset();             // limpa todas as variáveis da sessão
session_destroy();           // destrói a sessão por completo

header("Location: index.php"); // volta para a tela inicial
exit;

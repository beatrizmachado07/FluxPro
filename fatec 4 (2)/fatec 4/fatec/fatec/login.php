<?php
include_once("cabec.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    #container {
        margin-top: 50px;
        display: flex;
        justify-content: center;
    }

    .form-container {
        display: flex;
        flex-wrap: wrap;
        width: 90%;
        max-width: 800px;
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .left-box, .right-box {
        flex: 1 1 300px;
        padding: 30px;
    }

    .left-box {
        background-color: #1986a4;
        color: white;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .left-box h3 {
        margin-bottom: 20px;
    }

    .left-box button {
        background-color: transparent;
        border: 2px solid white;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .left-box button:hover {
        background-color: white;
        color: #1986a4;
    }

    .right-box {
        background-color: #fff;
        color: #333;
    }

    .right-box h2 {
        color: #1986a4;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .btn-custom {
        width: 100%;
        padding: 10px;
        background-color: #1986a4;
        color: white;
        border: none;
        font-weight: bold;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-custom:hover {
        background-color: #145f77;
    }

    .error-message {
        color: red;
        text-align: center;
        margin-bottom: 15px;
        font-weight: bold;
    }

    /* olho */
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-wrapper input {
        width: 100%;
        padding-right: 40px;
    }

    .password-wrapper img {
        position: absolute;
        right: 10px;
        width: 24px;
        height: 24px;
        cursor: pointer;
        opacity: 0.85;
        transition: 0.3s;
    }

    .password-wrapper img:hover {
        opacity: 1;
    }

    @media (max-width: 768px) {
        .form-container {
            flex-direction: column;
        }

        .left-box {
            border-radius: 12px 12px 0 0;
        }

        .right-box {
            border-radius: 0 0 12px 12px;
        }
    }
</style>

<div id="container">
    <div class="form-container">

        <div class="left-box">
            <h3><?= $lng['crieAcesso'] ?></h3>
            <button onclick="window.location.href='cadastro.php'"><?= $lng['cadastreSe'] ?></button>
        </div>

        <div class="right-box">
            <h2><?= $lng['entreContinuar'] ?></h2>
            <?php
            if (isset($_GET['erro']) && $_GET['erro'] == 1) {
                echo '<p class="error-message">'.($lng['usuarioSenhaInvalidos'] ?? 'Usuário ou senha inválidos.').'</p>';
            }
            ?>
            <form name="dados" action="autentica.php" method="POST">
                <div class="form-group">
                    <label for="nome"><?= $lng['nome'] ?>:</label>
                    <input type="text" name="nome" id="nome" required>
                </div>

                <div class="form-group">
                    <label for="senha"><?= $lng['senha'] ?>:</label>
                    <div class="password-wrapper">
                        <input type="password" name="senha" id="senha" required>
                        <img src="icones/olho_oculto.png" id="toggleSenha" alt="Mostrar senha">
                    </div>
                </div>

                <button type="submit" class="btn-custom"><?= $lng['entrar'] ?></button>
            </form>
        </div>

    </div>
</div>

<script>
const senhaInput = document.getElementById("senha");
const toggleIcon = document.getElementById("toggleSenha");

toggleIcon.addEventListener("click", function() {
    const isPassword = senhaInput.type === "password";
    senhaInput.type = isPassword ? "text" : "password";
    toggleIcon.src = isPassword ? "icones/olho.png" : "icones/olho_oculto.png";
});
</script>

<?php
include_once("rodape.php");
?>
